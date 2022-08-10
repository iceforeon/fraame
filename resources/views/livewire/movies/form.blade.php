<div>
    <form wire:submit.prevent="save" class="divide-y divide-gray-200">
      <div class="space-y-4">
        <div x-data="{}">
          <div class="relative shadow-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>

            @if ($search)
            <button class="absolute inset-y-0 right-0 pr-2" wire:click="clear">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
            @endif

            <input x-ref="search" type="text" wire:model.debounce.500ms="search" name="search" id="search" class="focus:ring-gray-500 focus:border-gray-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-sm" placeholder="Search">

            @if (count($results))
            <div class="z-50 absolute shadow-xl rounded-sm mt-2 border border-gray-200 inset-x-0">
              <ul class="divide-y divide-gray-200 bg-white overflow-hidden">
                @foreach ($results as $result)
                <li wire:click="pickMovie('{{ $result['id'] }}')" class="flex items-center hover:bg-gray-50 hover:cursor-pointer overflow-hidden">
                  <img src="{{ $result['poster_path'] }}" class="w-[50px] h-auto" alt="{{ $result['original_title'] }}">
                  <div class="p-3 overflow-hidden">
                    <h3 class="font-bold text-gray-600">{{ "{$result['original_title']} ({$result['year_released']})" }}</h3>
                    <p class="truncate text-gray-400">{{ $result['overview'] }}</p>
                  </div>
                </li>
                @endforeach
              </ul>
            </div>
            @endif
          </div>
        </div>

        <div class="sm:grid grid-cols-3 gap-4">
          <div class="col-span-2">
            <label for="title" class="text-sm font-semibold leading-6 text-gray-900">Title</label>
            <input wire:model.lazy="movie.title" type="text" name="title" id="title" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2">
          </div>

          <div class="mt-4 sm:mt-0">
            <label for="release_date" class="text-sm font-semibold leading-6 text-gray-900">Release Date</label>
            <input wire:model.lazy="movie.release_date" type="date" name="release_date" id="release_date" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2">
          </div>
        </div>

        <div class="sm:grid grid-cols-3 gap-4">
          <div class="col-span-2">
            <label for="genres" class="text-sm font-semibold leading-6 text-gray-900">Genres</label>
            <input wire:model.lazy="movie.genres" type="text" name="genres" id="genres" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2">
          </div>

          <div class="mt-4 sm:mt-0">
            <label for="tmdb_id" class="text-sm font-semibold leading-6 text-gray-900">TMDB ID</label>
            <input wire:model.lazy="movie.tmdb_id" type="text" name="tmdb_id" id="tmdb_id" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2">
          </div>
        </div>

        <div>
          <label for="overview" class="text-sm font-semibold leading-6 text-gray-900">Overview</label>
          <textarea wire:model.lazy="movie.overview" name="overview" id="overview" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm overflow-hidden mt-2" rows="5"></textarea>
        </div>

        <div>
          <label for="poster" class="text-sm font-semibold leading-6 text-gray-900">TMDB Poster</label>
          <div class="flex items-center justify-between border border-gray-300 shadow-sm px-3 py-2 mt-2">
            @if (empty($movie->tmdb_poster_path))
            <p class="text-sm">---</p>
            @else
            <a href="#" class="text-sm hover:underline focus:underline focus:outline-none">{{ $movie->tmdb_poster_path }}</a>
            @endif
          </div>
        </div>

        <div class="sm:grid grid-cols-3 gap-4">
          <div>
            <label for="imdb_id" class="text-sm font-semibold leading-6 text-gray-900">IMDB ID</label>
            <input wire:model.lazy="movie.imdb_id" type="text" name="imdb_id" id="imdb_id" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2">
          </div>

          <div class="mt-4 sm:mt-0">
            <label for="imdb_rank" class="text-sm font-semibold leading-6 text-gray-900">IMDB Rank</label>
            <input wire:model.lazy="movie.imdb_rank" type="text" name="imdb_rank" id="imdb_rank" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2">
          </div>

          <div class="mt-4 sm:mt-0">
            <label for="imdb_rating" class="text-sm font-semibold leading-6 text-gray-900">IMDB Rating</label>
            <input wire:model.lazy="movie.imdb_rating" type="text" name="imdb_rating" id="imdb_rating" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2">
          </div>
        </div>

        @if ($hashid)
        <div>
          <label for="frame" class="text-sm font-semibold leading-6 text-gray-900">Poster</label>
          <div class="flex items-center justify-between border border-gray-300 shadow-sm px-3 py-2 mt-2 space-x-2">
            @if (empty($movie->poster_path))
            <p class="text-sm">---</p>
            @else
            <a href="{{ $movie->poster_url }}" target="_blank" class="text-sm hover:underline focus:underline focus:outline-none truncate">
              {{ $movie->poster_path }}
            </a>
            @endif
            @if ($movie->poster_path)
            <div>
              <button wire:click="removePoster" type="button" class="text-gray-900 font-semibold text-xs uppercase hover:underline focus:underline focus:outline-none tracking-widest transition ease-in-out duration-150">Remove</button>
            </div>
            @endif
          </div>
        </div>

        <div class="sm:grid grid-cols-3 gap-4">
          <div>
            <label for="updated_at" class="text-sm font-semibold leading-6 text-gray-900">Updated At</label>
            <p class="text-sm mt-2">{{ $movie->updated_at_for_human }}</p>
          </div>

          <div class="mt-4 sm:mt-0">
            <label for="featured_at" class="text-sm font-semibold leading-6 text-gray-900">Featured At</label>
            <p class="text-sm mt-2">---</p>
          </div>
        </div>
        @endif
      </div>

      <div @class([
        'flex items-center mt-6 pt-4',
        'justify-end' => ! $hashid,
        'justify-between' => $hashid])>
        @if ($hashid)
        <button wire:click="delete" type="button" class="text-gray-900 font-semibold text-xs uppercase hover:underline focus:underline focus:outline-none tracking-widest transition ease-in-out duration-150" tabindex="-1">
          Delete
        </button>
        @endif
        <x-button>
          Save
        </x-button>
      </div>
    </form>
  </div>