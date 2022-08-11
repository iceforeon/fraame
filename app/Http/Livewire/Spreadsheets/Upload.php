<?php

namespace App\Http\Livewire\Spreadsheets;

use App\Enums\ItemType;
use App\Models\Spreadsheet;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;
use Livewire\WithFileUploads;

class Upload extends Component
{
    use WithFileUploads;

    public $file;

    public $type;

    protected function rules()
    {
        return [
            'file' => ['required', 'file', 'max:5000', 'mimes:xlsx'],
            'type' => ['nullable', new Enum(ItemType::class)],
        ];
    }

    public function mount()
    {
        $this->type = ItemType::Movie->value;
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

        Spreadsheet::create(['filename' => $filename, 'type' => $this->type]);

        $this->redirectRoute('dashboard');
    }
}
