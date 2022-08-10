<?php

namespace App\Http\Livewire\TvShows;

use App\Jobs\FetchTvShowData;
use App\Models\TvShow;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\SimpleExcel\SimpleExcelReader;

class Table extends Component
{
    use WithPagination;

    public $title = '';

    protected $queryString = ['title' => ['except' => '']];

    public function render()
    {
        return view('livewire.tv-shows.table', [
            'tvshows' => TvShow::query()
                ->when(strlen($this->title) >= 3, fn ($q) => $q->titleLike($this->title))
                ->imdbRank('asc')
                ->paginate(12),
        ]);
    }

    public function updatedTitle($value)
    {
        if (empty($value)) {
            $this->resetPage();
        }
    }

    public function import()
    {
        SimpleExcelReader::create(Storage::path('/exports/tvshows.xlsx'))
            ->getRows()
            ->each(fn ($tvshow) => FetchTvShowData::dispatch($tvshow));
    }
}
