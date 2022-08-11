<div>
    <form wire:submit.prevent="upload" class="divide-y divide-gray-200"  enctype="multipart/form-data">
      <div class="space-y-4">
        <pre>{{ $errors }}</pre>
        <div>
            <label for="type" class="text-sm font-semibold leading-6 text-gray-900">Type</label>
            <select wire:model.lazy="type" name="type" id="type" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2">
              @foreach (\App\Enums\ItemType::cases() as $itemType)
              <option value="{{ $itemType->value }}" {{ $type == $itemType->value ? 'selected' : null }}>{{ $itemType->name }}</option>
              @endforeach
            </select>
        </div>
        <div>
          <label for="file" class="text-sm font-semibold leading-6 text-gray-900">URL</label>
          <div class="mt-2">
            <input wire:model="file" type="file" name="file" class="focus:outline-none">
          </div>
        </div>
      </div>
      <div class="flex items-center justify-end mt-6 pt-4">
        <x-button wire:loading.attr="disabled" wire:target="upload">
          Upload<span wire:loading wire:target="upload">ing...</span>
        </x-button>
      </div>
    </form>
  </div>
