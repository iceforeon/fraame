<div>
  <form wire:submit.prevent="upload" class="divide-y divide-gray-200" enctype="multipart/form-data">
    <div class="space-y-4">
      <pre>{{ $errors }}</pre>
      <div>
        <label for="category" class="text-sm font-semibold leading-6 text-gray-900">Category</label>
        <select wire:model.lazy="category" name="category" id="category" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2">
          @foreach (\App\Enums\Category::cases() as $category)
          <option value="{{ $category->value }}" {{ $category==$category->value ? 'selected' : null }}>{{ $category->name }}</option>
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
