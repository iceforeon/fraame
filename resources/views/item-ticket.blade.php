<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Fraame') }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  {{-- set poster height using alpinejs lol --}}
  <div id="poster" x-data="poster" class="poster relative max-w-[500px] mx-auto mt-5 overflow-hidden">
    <div class="absolute inset-0 bg-center bg-cover blur-sm opacity-50" style="background-image: url('{{ config('services.tmdb.poster_url') . '/original/' . $item->poster_path }}')"></div>
    <div class="absolute inset-0 bg-black bg-opacity-75"></div>
    <div x-ref="wrapper" class="absolute px-8 py-10">
      <div class="flex items-center justify-center">
        <img src="{{ config('services.tmdb.poster_url') . '/w500/' . $item->poster_path }}" alt="{{ $item->title }}" class="w-[250px] shadow-xl">
      </div>
      <div class="px-8 mt-6 mb-4">
        <h1 class="font-bold text-xl tracking-wider text-center text-white">{!! strlen($item->title) > 30 ? Str::replaceFirst(':', ':<br />', $item->title) : $item->title !!}</h1>
      </div>
      <p class="text-center tracking-wide text-gray-200">{{ $item->year_released }}</p>
      <p class="text-center mt-2 text-gray-200">{{ $item->genres }}</p>
      <hr class="w-8 mx-auto my-4 opacity-30">
      <p class="leading-7 text-center text-gray-200">{{ Str::limit($item->overview, 400, '...') }}</p>
    </div>
    <div class="absolute bg-slate-900 inset-0 bg-opacity-10"></div>
  </div>
</body>
</html>
