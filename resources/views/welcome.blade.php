<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Fraame') }}</title>
  @vite(['resources/css/app.css'])
</head>
<body>
  <div class="absolute inset-0 flex items-center justify-center flex-col space-y-5">
    <a href="/" class="text-gray-900 font-bold">
      {{ config('app.name', 'Fraame') }}
    </a>
    @auth
    <p class="uppercase text-xs underline tracking-wider"><a href="/dashboard">dashboard</a></p>
    @endauth
    @guest
    <p class="uppercase text-xs underline tracking-wider"><a href="/login">login</a></p>
    @endguest
  </div>
</body>
</html>
