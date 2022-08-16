<div x-data="{ search: false }">
    <div x-cloak x-ref="search-form"
      x-show="search"
      x-transition:enter="transition ease-out duration-200"
      x-transition:enter-start="transform opacity-0 scale-95"
      x-transition:enter-end="transform opacity-100 scale-100"
      x-transition:leave="transition ease-in duration-75"
      x-transition:leave-start="transform opacity-100 scale-100"
      x-transition:leave-end="transform opacity-0 scale-95">
    <div class="relative rounded-sm shadow-sm mb-2">
      <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
        <svg wire:loading.remove wire:target="search" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>

        <svg wire:loading wire:target="search" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 256 256" class="h-5 w-5 text-gray-500 animate-spin">
          <line x1="128" y1="32" x2="128" y2="64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
          <line x1="195.9" y1="60.1" x2="173.3" y2="82.7" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
          <line x1="224" y1="128" x2="192" y2="128" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
          <line x1="195.9" y1="195.9" x2="173.3" y2="173.3" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
          <line x1="128" y1="224" x2="128" y2="192" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
          <line x1="60.1" y1="195.9" x2="82.7" y2="173.3" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
          <line x1="32" y1="128" x2="64" y2="128" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
          <line x1="60.1" y1="60.1" x2="82.7" y2="82.7" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line>
        </svg>
      </div>

      <input x-ref="search" wire:model.debounce.500ms="search" type="text" name="search" id="search" class="focus:ring-gray-500 focus:border-gray-500 block w-full pl-8 pr-12 sm:text-sm border-gray-300 rounded-sm" placeholder="Search...">

      <div class="absolute inset-y-0 right-0 flex items-center">
        <label for="category" class="sr-only">Category</label>
        <select wire:model="category" tabindex="-1" id="category" name="category" class="focus:ring-gray-500 focus:border-gray-500 h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-500 sm:text-sm rounded-sm">
          @foreach (\App\Enums\Category::tmdbCategories() as $category)
          <option value="{{ $category->value }}">{{ str($category->name)->when(str($category->name)->contains('TV'), fn ($str) => $str->replace('TV', 'TV '))->plural() }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>

  <div>
    <div class="grid grid-cols-3 gap-4">
      <div class="col-span-2">
        <input wire:model.lazy="title" type="text" name="title" id="title" maxlength="100" class="w-full pl-0 border-none focus:border-none focus:ring-0 focus:outline-none text-lg leading-6 font-medium text-gray-900" placeholder="Untitled Watchlist">
      </div>

      <div class="flex items-center justify-end">
        <button x-on:click="search = ! search" tabindex="-1" type="button" class="text-gray-900 text-xs uppercase hover:underline focus:underline focus:outline-none tracking-widest transition ease-in-out duration-150 font-semibold">Search</button>
      </div>
    </div>

    <div class="mt-2">
      <div class="mt-1 relative rounded-md shadow-sm">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <span class="text-gray-500 sm:text-sm">I want</span>
        </div>

        <input wire:model.debounce="quantity" type="number" name="quantity" id="quantity" min="0" max="10" class="quantity focus:ring-gray-500 focus:border-gray-500 block w-full pl-16 pr-12 sm:text-sm border-gray-300 rounded-sm" placeholder="0">

        <div class="absolute inset-y-0 right-0 flex items-center">
          <label for="category" class="sr-only">Category</label>

          <select id="category" name="category" class="focus:ring-gray-500 focus:border-gray-500 h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-500 sm:text-sm rounded-sm">
            @foreach (\App\Enums\Category::cases() as $category)
            <option value="{{ $category->value }}">{{ str($category->name)->when(str($category->name)->contains('TV'), fn ($str) => $str->replace('TV', 'TV '))->plural() }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>

    @if ($items)
    <div class="mt-2 space-y-2">
      @foreach ($items as $item)
        <div wire:sortable.item="{{ $item['id'] }}" wire:key="item-{{ $item['id'] }}" class="mt-4 border border-gray-200 rounded-sm h-[64px] flex items-center justify-between text-gray-400 px-4 space-x-1">
          <h3 class="truncate">
            <a href="" class="text-gray-500 hover:text-gray-700 focus:outline-none focus:underline" tabindex="-1">
              {{ "{$item['title']} ({$item['year_released']})" }}
            </a>
          </h3>

          <div class="flex items-center space-x-3">
            <button wire:click="lockItem('{{ $item['id'] }}')" type="button" tabindex="-1" @class(['text-gray-400 hover:text-gray-600', 'locked'=> $item['locked']])>
              @if (! $item['locked'])
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
              @else
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
              </svg>
              @endif
            </button>

            <a href class="text-gray-400 hover:text-gray-600" tabindex="-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </a>

            <button wire:click="removeItem('{{ $item['id'] }}')" type="button" class="text-gray-400 hover:text-gray-600" tabindex="-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </button>
          </div>
        </div>
      @endforeach
    </div>
    @endif

    @if (count($items) < $quantity) <div class="mt-2 space-y-2">
      @for ($i = 0; $i < $quantity - count($items); $i++)
        <div class="border border-dashed border-gray-200 rounded-sm h-[64px] flex items-center justify-center text-gray-400"></div>
      @endfor
    @endif
</div>

  <div @class([ 'mt-4 flex items-center' , 'justify-between'=> count($items) > 0, 'justify-end' => count($items) == 0])>
    @if (count($items) > 0)
    <button tabindex="-1" type="button" class="text-gray-900 font-semibold text-xs uppercase hover:underline focus:underline focus:outline-none tracking-widest ">Reset</button>
    @endif

    <div x-data="{ open: false }" x-on:click.outside="open = false" x-on:close.stop="open = false">
      <div class="w-full relative z-0 inline-flex shadow-sm rounded-sm">
        <button wire:click="generate" type="button" class="w-full relative inline-flex items-center px-4 py-2 rounded-l-sm border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
          <span wire:loading.remove wire:target="generate">Submit</span>
          <span wire:loading wire:target="generate">Loading...</span>
        </button>
        <div class="-ml-px relative block">
          <button x-on:click="open = ! open" type="button" class="relative inline-flex items-center px-2 py-2 rounded-r-sm border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500" id="option-menu-button" aria-expanded="true" aria-haspopup="true">
            <span class="sr-only">Open options</span>
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </button>

          <div x-cloak x-show="open" x-on:click="open = false" class="origin-top-right absolute right-0 mt-2 -mr-1 w-56 rounded-sm shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="option-menu-button" tabindex="-1">
            <div class="py-1" role="none">
              <button type="button" class="w-full text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100 transition duration-150 ease-in-out text-left" role="menuitem" tabindex="-1" id="option-menu-item-0">Copy to clipboard</a>
              <button type="button" class="w-full text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100 transition duration-150 ease-in-out text-left" role="menuitem" tabindex="-1" id="option-menu-item-2">Export to text file</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
