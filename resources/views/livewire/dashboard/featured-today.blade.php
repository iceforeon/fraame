<div class="px-4">
  <ul role="list" class="divide-y divide-gray-200">
    <li class="py-4">
      <div class="flex">
        <div class="flex-1 space-y-1">
          <div class="flex items-center justify-between">
            <h3 class="text-sm font-medium">{{ $movie ? "{$movie->title} ({$movie->year_released})" : '---' }}</h3>
            @if ($movie)
            <a href="" class="text-gray-900 text-xs uppercase hover:underline focus:underline focus:outline-none tracking-widest transition ease-in-out duration-150 font-semibold">VIEW</a>
            @endif
          </div>
          <p class="text-sm text-gray-500">Movie</p>
        </div>
      </div>
    </li>

    <li class="py-4">
      <div class="flex">
        <div class="flex-1 space-y-1">
          <div class="flex items-center justify-between">
            <h3 class="text-sm font-medium">{{ $tvshow ? "{$tvshow->title} ({$tvshow->year_released})" : '---' }}</h3>
            @if ($tvshow)
            <a href="" class="text-gray-900 text-xs uppercase hover:underline focus:underline focus:outline-none tracking-widest transition ease-in-out duration-150 font-semibold">VIEW</a>
            @endif
          </div>
          <p class="text-sm text-gray-500">TV Show</p>
        </div>
      </div>
    </li>

    <li class="py-4">
      <div class="flex">
        <div class="flex-1 space-y-1">
          <div class="flex items-center justify-between">
            <h3 class="text-sm font-medium">{{ $anime ? "{$anime->title} ({$anime->year_released})" : '---' }}</h3>
            @if ($anime)
            <a href="" class="text-gray-900 text-xs uppercase hover:underline focus:underline focus:outline-none tracking-widest transition ease-in-out duration-150 font-semibold">VIEW</a>
            @endif
          </div>
          <p class="text-sm text-gray-500">Anime</p>
        </div>
      </div>
    </li>
  </ul>
</div>
