<?php

namespace App\Http\Livewire\Items;

use App\Enums\ItemType;
use App\Jobs\FetchMovieData;
use App\Jobs\FetchTvShowData;
use App\Models\Item;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\SimpleExcel\SimpleExcelReader;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Symfony\Component\DomCrawler\Crawler;

class ItemsTable extends Component
{
    use WithPagination;

    public $title = '';

    protected $queryString = ['title' => ['except' => '']];

    public function render()
    {
        return view('livewire.items.items-table', [
            'items' => Item::query()
                ->when(strlen($this->title) >= 3, fn ($q) => $q->titleLike($this->title))
                ->orderByRaw('convert(imdb_rank, signed) asc')
                ->paginate(12),
        ]);
    }

    public function updatedTitle($value)
    {
        if (empty($value)) {
            $this->resetPage();
        }
    }

    public function scrape()
    {
        // https://www.imdb.com/chart/top
        // table[data-caller-name="chart-top250movie"]

        // https://www.imdb.com/chart/toptv
        // table[data-caller-name="chart-top250tv"]

        $response = Http::withHeaders(['Accept-Language' => 'en-US'])
            ->get('https://www.imdb.com/chart/toptv');

        $crawler = (new Crawler($response->body()));

        $items = $crawler->filter('table[data-caller-name="chart-top250tv"] tbody.lister-list tr')->each(function ($node, $key) {
            $idTitle = $node->filter('tr > td.titleColumn a')->each(function ($anchor) {
                $id = explode('/', trim($anchor->attr('href')))[2];
                $title = trim($anchor->text());

                return "{$id}|{$title}";
            })[0];

            $yearReleased = $node->filter('tr > td.titleColumn span')->each(function ($span) {
                return str_replace(['(', ')'], '', trim($span->text()));
            })[0];

            $rating = $node->filter('tr > td.ratingColumn')->each(function ($strong) {
                return trim($strong->text());
            })[0];

            return [
                'imdb_rank' => $key + 1,
                'imdb_id' => explode('|', $idTitle)[0],
                'title' => explode('|', $idTitle)[1],
                'year_released' => $yearReleased,
                'imdb_rating' => $rating,
            ];
        });

        // movies.xlsx
        // tvshow.xlsx

        SimpleExcelWriter::create(Storage::path('/exports/movies.xlsx'))
            ->addRows($items);

        return response()
            ->download(Storage::path('/exports/movies.xlsx'));
    }

    public function import()
    {
        SimpleExcelReader::create(Storage::path('/exports/movies.xlsx'))
            ->getRows()
            ->each(fn ($item) => FetchMovieData::dispatch($item));

        SimpleExcelReader::create(Storage::path('/exports/tvshow.xlsx'))
            ->getRows()
            ->each(fn ($item) => FetchTvShowData::dispatch($item));
    }

    // public function discrepancies()
    // {
    //     dd(array_diff(
    //         collect(
    //             SimpleExcelReader::create(Storage::path('/exports/tvshow.xlsx'))
    //                 ->getRows()
    //                 ->all()
    //         )
    //             ->pluck('imdb_id')
    //             ->toArray(),
    //         Item::where('type', ItemType::TVShow)->pluck('imdb_id')->toArray()
    //     ));
    // }
}
