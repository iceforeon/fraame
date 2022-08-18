<?php

namespace App\Http\Livewire\Spreadsheets;

use App\Enums\Category;
use App\Jobs\FetchAnimeData;
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

    public $filename = '';

    protected $queryString = [
        'filename' => [
            'except' => '',
        ],
    ];

    public function render()
    {
        return view('livewire.spreadsheets.table', [
            'spreadsheets' => Spreadsheet::query()
                ->when(strlen($this->filename) >= 3, fn ($q) => $q->filenameLike($this->filename))
                ->latest()
                ->paginate(12),
        ]);
    }

    public function delete($hashid)
    {
        Spreadsheet::find($hashid)->delete();

        $this->redirectRoute('dashboard');
    }

    public function import($hashid)
    {
        $spreadsheet = Spreadsheet::findOr($hashid, fn () => abort(404));

        $path = Storage::disk('spreadsheets')->path($spreadsheet->filename);

        if ($spreadsheet->category == Category::Movie) {
            SimpleExcelReader::create($path)
                ->getRows()
                ->each(fn ($movie) => FetchMovieData::dispatch($movie));
        }

        if ($spreadsheet->category == Category::TVShow) {
            SimpleExcelReader::create($path)
                ->getRows()
                ->each(fn ($tvshow) => FetchTvShowData::dispatch($tvshow));
        }

        if ($spreadsheet->category == Category::Anime) {
            SimpleExcelReader::create($path)
                ->getRows()
                ->each(fn ($anime) => FetchAnimeData::dispatch($anime));
        }
    }
}
