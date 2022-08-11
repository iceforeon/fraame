<div>
  <div class="inline-flex flex-col justify-center space-y-6 px-4 sm:px-0">
    @if ($item)
    <div>
      <a href="#">
        <div id="poster" class="relative max-w-[550px] mx-auto inline-flex items-center justify-center overflow-hidden rounded-sm">
          <div class="px-8 py-10 sm:p-10 flex items-center sm:justify-center flex-col">
            <div class="bg-cover absolute inset-0 blur-sm z-[-2] opacity-75" style="background-image: url('{{ config('services.tmdb.poster_url') . '/original/' . $item->tmdb_poster_path }}')"></div>
            <div class="absolute inset-0 bg-black bg-opacity-80 z-[-1]"></div>
            {{-- <img src="{{ config('services.tmdb.poster_url') . '/w500/' . $item->tmdb_poster_path }}" alt="{{ $item->title }}" class="max-w-[250px] z-50"> --}}
            <div class="sm:px-8 mt-6 mb-4 sm:mb-2">
              <h1 class="font-bold text-xl tracking-wider sm:text-center text-white">{!! strlen($item->title) > 30 ? Str::replaceFirst(':', ':<br />', $item->title) : $item->title !!}</h1>
            </div>
            <div>
              <p class="text-center tracking-wide text-gray-200">{{ $item->year_released }}</p>
              <p class="text-center mt-1 text-gray-200">{{ $item->genres }}</p>
              <hr class="w-6 mx-auto my-4 opacity-30">
              <p class="sm:text-center leading-7 text-gray-200">{{ $item->overview }}</p>
            </div>
            <div class="absolute inset-0 bg-black bg-opacity-10 z-[10]"></div>
          </div>
        </div>
      </a>
    </div>
    @endif
    <div>
      <button x-data="{ refresh() { $refs.randomBtn.setAttribute('disabled'); $wire.emitSelf('refreshComponent'); } }" x-ref="randomBtn" x-on:click="refresh" type="button" class="w-full h-full px-4 py-2 bg-gray-800 border border-transparent font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 rounded-sm text-center">Random</button>
    </div>
  </div>
</div>
