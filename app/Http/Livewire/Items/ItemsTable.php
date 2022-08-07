<?php

namespace App\Http\Livewire\Items;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
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
            'items' => [],
        ]);
    }

    public function scrape()
    {
        $response = Http::withHeaders(['Accept-Language' => 'en-US'])
            ->get('https://www.imdb.com/chart/top');

        $crawler = (new Crawler($response->body()));

        $items = $crawler->filter('td.titleColumn')->each(function ($node) {
            $idTitle = $node->filter('a')->each(function ($anchorTag) {
                $id = explode('/', trim($anchorTag->attr('href')))[2];
                $title = trim($anchorTag->text());

                return "{$id}|{$title}";
            })[0];

            $yearReleased = $node->filter('span')->each(function ($span) {
                return str_replace(['(', ')'], '', trim($span->text()));
            })[0];

            return [
                'imdb_id' => explode('|', $idTitle)[0],
                'title' => explode('|', $idTitle)[1],
                'year_released' => $yearReleased,
            ];
        });

        SimpleExcelWriter::create(Storage::path('/exports/movies.xlsx'))
            ->noHeaderRow()
            ->addRows($items);

        return response()
            ->download(Storage::path('/exports/movies.xlsx'));
    }
}
