<?php

namespace App\Http\Livewire\Spreadsheets;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Symfony\Component\DomCrawler\Crawler;

class Scraper extends Component
{
    public $strategy;

    public $strategies = [
        'imdb250' => [
            'name' => 'IMDB Top 250',
            'parent' => 'table[data-caller-name="chart-top250movie"] tbody.lister-list tr',
            'title' => 'tr > td.titleColumn a',
            'year_released' => 'tr > td.titleColumn span',
            'rating' => 'tr > td.ratingColumn',
        ],
        'imdbCompact' => [
            'name' => 'IMDB Compact',
            'parent' => '.lister-list .lister-item.mode-simple',
            'title' => '.lister-item-content .lister-col-wrapper .col-title span:nth-child(2) a',
            'year_released' => '.lister-item-content .lister-col-wrapper .col-title span:nth-child(2) span',
            'rating' => '.lister-item-content .lister-col-wrapper .col-imdb-rating',
        ],
    ];

    public $url;

    public $parent_wrapper;

    public $title_wrapper;

    public $year_released_wrapper;

    public $rating_wrapper;

    public function render()
    {
        return view('livewire.spreadsheets.scraper');
    }

    public function updatedStrategy($value)
    {
        if (empty($value)) {
            return $this->reset([
                'parent_wrapper',
                'title_wrapper',
                'year_released_wrapper',
                'rating_wrapper',
            ]);
        }

        if (isset($this->strategies[$value])) {
            $this->parent_wrapper = $this->strategies[$value]['parent'];
            $this->title_wrapper = $this->strategies[$value]['title'];
            $this->year_released_wrapper = $this->strategies[$value]['year_released'];
            $this->rating_wrapper = $this->strategies[$value]['rating'];
        }
    }

    public function scrape()
    {
        $response = Http::retry(3, 300)
            ->withHeaders(['Accept-Language' => 'en-US'])
            ->get($this->url);

        $crawler = (new Crawler($response->body()));

        $items = $crawler->filter($this->parent_wrapper)->each(function ($node, $key) {
            $idTitle = $node->filter($this->title_wrapper)->each(function ($anchor) {
                $id = explode('/', trim($anchor->attr('href')))[2];
                $title = trim($anchor->text());

                return "{$id}|{$title}";
            })[0];

            $yearReleased = $node->filter($this->year_released_wrapper)->each(function ($span) {
                return str_replace(['(', ')'], '', trim($span->text()));
            })[0];

            $rating = $node->filter($this->rating_wrapper)->each(function ($strong) {
                return trim($strong->text());
            })[0];

            return [
                'imdb_id' => explode('|', $idTitle)[0],
                'title' => explode('|', $idTitle)[1],
                'year_released' => $yearReleased,
                'imdb_rating' => $rating,
            ];
        });

        SimpleExcelWriter::create(Storage::path('scrape.xlsx'))
            ->addRows($items);

        return response()
            ->download(Storage::path('scrape.xlsx'));
    }
}
