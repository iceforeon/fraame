<div>
  <form wire:submit.prevent="scrape" class="divide-y divide-gray-200">
    <div class="space-y-4">
      <div>
        <label for="strategy" class="text-sm font-semibold leading-6 text-gray-900">Strategy</label>
        <select wire:model.lazy="strategy" name="strategy" id="strategy" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2">
          <option value="">---</option>
          @foreach ($strategies as $key => $value)
          <option class="rounded-none" value="{{ $key }}">{{ $value['name'] }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label for="url" class="text-sm font-semibold leading-6 text-gray-900">URL</label>
        <input wire:model.lazy="url" type="text" name="url" id="url" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2">
      </div>

      <div>
        <label for="parent_wrapper" class="text-sm font-semibold leading-6 text-gray-900">Parent Wrapper</label>
        <input wire:model.lazy="parent_wrapper" type="text" name="parent_wrapper" id="parent_wrapper" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2">
      </div>

      <div>
        <label for="title_wrapper" class="text-sm font-semibold leading-6 text-gray-900">Title Wrapper</label>
        <input wire:model.lazy="title_wrapper" type="text" name="title_wrapper" id="title_wrapper" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2">
      </div>

      <div>
        <label for="year_released_wrapper" class="text-sm font-semibold leading-6 text-gray-900">Year Released Wrapper</label>
        <input wire:model.lazy="year_released_wrapper" type="text" name="year_released_wrapper" id="year_released_wrapper" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2">
      </div>

      <div>
        <label for="rating_wrapper" class="text-sm font-semibold leading-6 text-gray-900">Rating Wrapper</label>
        <input wire:model.lazy="rating_wrapper" type="text" name="rating_wrapper" id="rating_wrapper" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2">
      </div>
    </div>
    <div class="flex items-center justify-end mt-6 pt-4">
      <x-button wire:loading.attr="disabled">
        <span wire:loading.remove wire:target="scrape">Scrape</span>
        <span wire:loading wire:target="scrape">Scraping...</span>
      </x-button>
    </div>
  </form>
</div>
