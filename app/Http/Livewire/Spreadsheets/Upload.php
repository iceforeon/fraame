<?php

namespace App\Http\Livewire\Spreadsheets;

use App\Enums\Category;
use App\Models\Spreadsheet;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;
use Livewire\WithFileUploads;

class Upload extends Component
{
    use WithFileUploads;

    public $file;

    public $category;

    protected function rules()
    {
        return [
            'file' => ['required', 'file', 'max:5000', 'mimes:xlsx'],
            'category' => ['nullable', new Enum(Category::class)],
        ];
    }

    public function mount()
    {
        $this->category = Category::Movie->value;
    }

    public function render()
    {
        return view('livewire.spreadsheets.upload');
    }

    public function upload()
    {
        $this->validate();

        $filename = explode('.', $this->file->getClientOriginalName());

        $filename = "{$filename[0]}-".now()->format('Y-m-d').".{$filename[1]}";

        $this->file->storeAs(DIRECTORY_SEPARATOR, $filename, 'spreadsheets');

        Spreadsheet::create(['filename' => $filename, 'category' => $this->category]);

        $this->redirectRoute('dashboard');
    }
}
