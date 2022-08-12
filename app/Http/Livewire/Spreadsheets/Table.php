<?php

namespace App\Http\Livewire\Spreadsheets;

use App\Enums\ItemType;
use App\Jobs\FetchMovieData;
use App\Jobs\FetchTvShowData;
use App\Models\Spreadsheet;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\SimpleExcel\SimpleExcelReader;

class Table extends Component
{
    use WithPagination;

    public $title = '';

    protected $queryString = [
        'title' => [
            'except' => '',
        ],
    ];

    public function render()
    {
        return view('livewire.spreadsheets.table', [
            'spreadsheets' => Spreadsheet::query()
                ->when(strlen($this->title) >= 3, fn ($q) => $q->titleLike($this->title))
                ->latest()
                ->paginate(12),
        ]);
    }

    public function delete($hashid)
    {
        dd($hashid);
    }

    public function import($hashid)
    {
        $spreadsheet = Spreadsheet::findOr($hashid, fn () => abort(404));

        $path = Storage::disk('spreadsheets')->path($spreadsheet->filename);

        if ($spreadsheet->type == ItemType::Movie) {
            SimpleExcelReader::create($path)
                ->getRows()
                ->each(fn ($movie) => FetchMovieData::dispatch($movie));
        }

        if ($spreadsheet->type == ItemType::TVShow) {
            SimpleExcelReader::create($path)
                ->getRows()
                ->each(fn ($tvshow) => FetchTvShowData::dispatch($tvshow));
        }
    }
}
