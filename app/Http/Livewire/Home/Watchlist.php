<?php

namespace App\Http\Livewire\Home;

use App\Enums\Category;
use App\Models\Movie;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Watchlist extends Component
{
    const MAX_QUANTITY = 10;

    const DEFAULT_QUANTITY = 5;

    public $title;

    public $quantity = self::DEFAULT_QUANTITY;

    public $category;

    public $items = [];

    public $showSearch = false;

    public $search;

    public $results = [];

    public function mount()
    {
        $this->category = Category::Movie->value;

        $this->searchCategory = Category::Movie->value;

        $this->pushItems(
            Movie::query()
                ->inRandomOrder()
                ->get()
                ->take($this->quantity)
        );
    }

    public function render()
    {
        return view('livewire.home.watchlist');
    }

    public function generate()
    {
        sleep(1);

        $locked = collect($this->items)->filter(fn ($item) => $item['locked'])->toArray();

        if (count($locked) == $this->quantity) {
            return dd('list is complete');
        }

        if (count($locked)) {
            $this->items = $locked;
        } else {
            $this->reset('items');
        }

        if (count($this->items) < $this->quantity) {
            $quantity = $this->quantity - count($this->items);
        }

        $this->pushItems(
            Movie::query()
                ->whereNotIn('id', collect($this->items)->pluck('id')->toArray())
                ->inRandomOrder()
                ->get()
                ->take($quantity ?? $this->quantity)
        );

        $this->fixItemOrdering();
    }

    public function updatedQuantity($value)
    {
        $this->quantity = (int) preg_replace('/[^0-9]/', '', $value);

        if ($this->quantity > self::MAX_QUANTITY) {
            $this->quantity = self::MAX_QUANTITY;
        }
    }

    public function updatedSearch($value)
    {
        $this->results = strlen(trim($value)) > 3 ? $this->itemSearch() : [];
    }

    public function updatedCategory()
    {
        $this->reset(['search', 'results']);
    }

    public function itemSearch()
    {
        $category = $this->category == Category::Movie->value ? 'movie' : 'tv';

        $results = Http::retry(3, 300)
            ->withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.api_url')."/search/{$category}?query=".$this->search)
            ->json()['results'];

        return collect($results)
            ->when($this->category == Category::Movie->value, function ($results) {
                return $results->filter(fn ($result) => isset($result['release_date']));
            })
            ->when($this->category == Category::TVShow->value, function ($results) {
                return $results->filter(fn ($result) => isset($result['first_air_date']));
            })
            ->when($this->category == Category::Anime->value, function ($results) {
                return $results->filter(fn ($result) => in_array(16, $result['genre_ids']) && isset($result['first_air_date']));
            })
            ->filter(function ($result) {
                return ! $this->idExists($result['id']);
            })
            ->map(function ($result) {
                return collect($result)->merge([
                    'title' => $this->category == Category::Movie->value
                        ? $result['title']
                        : $result['name'],
                    'poster_path' => $result['poster_path']
                        ? config('services.tmdb.poster_url').'/w200/'.$result['poster_path']
                        : '/img/no-poster.png',
                    'year_released' => Carbon::parse(
                        $this->category == Category::Movie->value
                            ? $result['release_date']
                            : $result['first_air_date']
                    )->format('Y'),
                ])->only(['id', 'poster_path', 'title', 'year_released', 'overview']);
            })->take(5);
    }

    public function addItem($id)
    {
        $category = $this->category == Category::Movie->value
            ? 'movie'
            : 'tv';

        $item = Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.api_url')."/{$category}/".$id)
            ->json();

        if (
            ! $this->idExists($item['id']) &&
            count($this->items) + 1 <= self::MAX_QUANTITY
        ) {
            $this->items[] = [
                'order' => count($this->items) + 1,
                'locked' => false,
                'id' => $item['id'],
                'category' => $this->category,
                'title' => $this->category == Category::Movie->value
                    ? $item['title']
                    : $item['name'],
                'year_released' => Carbon::parse(
                    $this->category == Category::Movie->value
                        ? $item['release_date']
                        : $item['first_air_date']
                )->format('Y'),
            ];
        }

        $this->reset(['search', 'results']);
    }

    public function lockItem($id)
    {
        $this->items = collect($this->items)
            ->map(function ($item) use ($id) {
                return [
                    'order' => $item['order'],
                    'locked' => $item['id'] == $id
                        ? $item['locked'] = ! $item['locked']
                        : $item['locked'] = $item['locked'],
                    'id' => $item['id'],
                    'category' => $item['category'],
                    'title' => $item['title'],
                    'year_released' => $item['year_released'],
                ];
            })
                ->toArray();
    }

    public function removeItem($id)
    {
        $this->items = collect($this->items)
            ->filter(fn ($item) => (int) $item['id'] !== (int) $id)
            ->toArray();
    }

    public function idExists($id)
    {
        return collect($this->items)
            ->filter(fn ($item) => $item['id'] == $id)
            ->count() ? true : false;
    }

    public function clear()
    {
        $this->reset(['showSearch', 'quantity', 'items']);

        $this->category = Category::Movie->value;

        $this->pushItems(
            Movie::query()
                ->inRandomOrder()
                ->get()
                ->take($this->quantity)
        );
    }

    public function pushItems($items)
    {
        foreach ($items as $item) {
            $this->items[] = [
                'order' => count($this->items) + 1,
                'locked' => false,
                'id' => $item['tmdb_id'],
                'category' => $this->category,
                'title' => $this->category == Category::Movie->value
                    ? $item['title']
                    : $item['name'],
                'year_released' => Carbon::parse(
                    $this->category == Category::Movie->value
                        ? $item['release_date']
                        : $item['first_air_date']
                )->format('Y'),
            ];
        }
    }

    public function fixItemOrdering()
    {
        $this->items = collect(array_values($this->items))
            ->map(function ($item, $key) {
                return [
                    'order' => $key + 1,
                    'locked' => $item['locked'],
                    'id' => $item['id'],
                    'category' => $item['category'],
                    'title' => $item['title'],
                    'year_released' => $item['year_released'],
                ];
            })
            ->toArray();
    }

    public function sortItems($items)
    {
        $this->items = collect($items)
            ->map(fn ($item) => collect($this->items)->where('id', $item['value'])->first())
            ->toArray();

        $this->fixItemOrdering();
    }

    public function export()
    {
        if (! count($this->items)) {
            return;
        }

        $title = $this->title ?? 'Untitled';

        return response()
            ->streamDownload(function () use ($title) {
                echo "{$title}\n\n";
                echo implode("\n\n", collect($this->items)->map(function ($item) {
                    $url = url($item['category'].'/'.$item['id']);
                    $title = "{$item['title']} ({$item['year_released']})";

                    return $title."\n".$url;
                })->toArray());
            }, str($title)
                ->slug()
                ->toString().'.txt');
    }
}
