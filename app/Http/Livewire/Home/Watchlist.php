<?php

namespace App\Http\Livewire\Home;

use App\Enums\Category;
use App\Models\Movie;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Watchlist extends Component
{
    const MAX_QUANTITY = 10;

    const DEFAULT_QUANTITY = 5;

    public $quantity = self::DEFAULT_QUANTITY;

    public $category;

    public $items = [];

    public function mount()
    {
        $this->category = Category::Movie->value;

        $items = Movie::inRandomOrder()
            ->get()
            ->take($this->quantity);

        foreach ($items as $item) {
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

        $items = Movie::inRandomOrder()
            ->get()
            ->take($quantity ?? $this->quantity);

        foreach ($items as $item) {
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
    }

    public function lockItem($id)
    {
        $this->items = collect($this->items)
            ->map(function ($item) use ($id) {
                return [
                    'order' => $item['order'],
                    'locked' => $item['id'] == (int) $id
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
            ->filter(fn ($item) => $item['id'] !== (int) $id)
            ->toArray();
    }

    public function updatedQuantity($value)
    {
        $this->quantity = (int) preg_replace('/[^0-9]/', '', $value);

        if ($this->quantity > self::MAX_QUANTITY) {
            $this->quantity = self::MAX_QUANTITY;
        }
    }
}
