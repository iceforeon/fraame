<div class="max-w-6xl mx-auto flex flex-col space-y-8 sm:space-y-10 items-center py-4 px-4 mt-4 sm:mt-8">
  <div class="grow">
    <h1 class="text-center text-lg sm:text-2xl font-extrabold tracking-tight text-slate-900 leading-tight">What to watch</h1>
    <div class="flex flex-col sm:flex-row sm:space-x-6 space-y-4 sm:space-y-0 mt-5 sm:mt-10">
      @foreach ($items as $item)
        <a href="" class="max-w-[282px] flex flex-col focus:shadow-lg focus:outline-none bg-white rounded-sm p-4 shadow-sm hover:shadow-lg transition ease-in-out duration-150">
          <img src="{{ config('services.tmdb.poster_url') . '/w500/'.$item->tmdb_poster_path }}" alt="{{ $item->title }}" class="w-[250px] min-h-[375px] rounded-sm">
          <h2 class="mt-2 text-center font-bold">{!! strlen($item->title) > 25 ? Str::replaceFirst(':', ':<br />', $item->title) : $item->title !!}</h2>
          <p class="text-center">{{ $item->year_released }}</p>
        </a>
      @endforeach

      @if (! count($items))
        @for ($i = 0; $i < 3; $i++)
        <div class="w-[282px] h-[463px] grow border-2 border-dashed border-gray-200 rounded-sm flex items-center justify-center text-gray-400"></div>
        @endfor
      @endif
    </div>
  </div>

  <div>
    <a href="{{ route('watchlist') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Create your watchlist</a>
  </div>
</div>
