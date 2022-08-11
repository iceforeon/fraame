<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Fraame') }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  <div x-data="{}" x-init="$nextTick(() => { document.getElementById('poster').classList.add('poster-idle') })" id="poster" class="relative max-w-[550px] mx-auto flex items-center justify-center overflow-hidden">
    <div class="p-10 flex items-center justify-center flex-col">
      <div class="bg-cover absolute inset-0 blur-sm z-[-2] opacity-75" style="background-image: url('{{ config('services.tmdb.poster_url') . '/original/' . $item->tmdb_poster_path }}')"></div>
      <div class="absolute inset-0 bg-black bg-opacity-80 z-[-1]"></div>
      <img src="{{ config('services.tmdb.poster_url') . '/w500/' . $item->tmdb_poster_path }}" alt="{{ $item->title }}" class="w-[250px] z-50">
      <div class="px-8 mt-6 mb-2">
        <h1 class="font-bold text-xl tracking-wider text-center text-white">{!! strlen($item->title) > 30 ? Str::replaceFirst(':', ':<br />', $item->title) : $item->title !!}</h1>
      </div>
      <div>
        <p class="text-center tracking-wide text-gray-200">{{ $item->year_released }}</p>
        <p class="text-center mt-1 text-gray-200">{{ $item->genres }}</p>
        <hr class="w-6 mx-auto my-4 opacity-30">
        <p class="leading-7 text-center text-gray-200">{{ $item->overview }}</p>
      </div>
      <div class="absolute inset-0 bg-black bg-opacity-10 z-[10]"></div>
    </div>
  </div>
</body>
</html>
