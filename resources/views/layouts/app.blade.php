<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Fraame') }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
  @livewireScripts
</head>
<body class="font-sans antialiased flex flex-col h-full bg-gray-100">
  <header class="bg-white">
    <nav class="max-w-3xl mx-auto flex items-center justify-between py-4 px-4">
      <div>
        <a href="/" class="text-gray-900 font-bold hover:text-gray-700 hover:underline focus:underline transition ease-in-out duration-150">{{ config('app.name', 'Fraame') }}</a>
      </div>
      <ul class="flex items-center space-x-4">
        @auth
        @if (auth()->user()->isDeveloper())
        <li>
          <a href="{{ route('dashboard') }}" class="uppercase text-xs hover:underline tracking-wider transition ease-in-out duration-150">dashboard</a>
        </li>
        @endif
        @if (! auth()->user()->isDeveloper())
        <li>
          <a href="{{ route('watchlists.index') }}" class="uppercase text-xs hover:underline tracking-wider transition ease-in-out duration-150">watchlists</a>
        </li>
        @endif
        @endauth
        @guest
        <li>
          <a href="{{ route('login') }}" class="uppercase text-xs hover:underline tracking-wider transition ease-in-out duration-150">login</a>
        </li>
        @endguest
      </ul>
    </nav>
  </header>
  <main class="grow shrink-0 basis-auto">
    {{ $slot }}
  </main>
  <footer class="shrink-0">
    <div class="bg-white">
      <div class="max-w-3xl mx-auto flex items-center justify-between py-4 px-4 mt-5">
        <div>
          <a href="https://www.themoviedb.org" class="uppercase text-xs hover:underline tracking-wider transition ease-in-out duration-150">tmdb</a>
        </div>
        <div class="flex items-center justify-between space-x-3">
          <a href="https://www.facebook.com/fraaaame" target="_blank" class="text-gray-700 hover:text-gray-600 focus:text-gray-600 focus:outline-none transition ease-in-out duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36" fill="currentColor" class="w-4">
              <path d="M15 35.8C6.5 34.3 0 26.9 0 18 0 8.1 8.1 0 18 0s18 8.1 18 18c0 8.9-6.5 16.3-15 17.8l-1-.8h-4l-1 .8z"></path>
              <path fill="white" d="M25 23l.8-5H21v-3.5c0-1.4.5-2.5 2.7-2.5H26V7.4c-1.3-.2-2.7-.4-4-.4-4.1 0-7 2.5-7 7v4h-4.5v5H15v12.7c1 .2 2 .3 3 .3s2-.1 3-.3V23h4z"></path>
            </svg>
          </a>
          <a href="https://github.com/iceforeon/fraame" target="_blank" class="text-gray-700 hover:text-gray-600 focus:text-gray-600 focus:outline-none transition ease-in-out duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4">
              <path fill-rule="evenodd" d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z"></path>
            </svg>
          </a>
        </div>
      </div>
    </div>
  </footer>
</body>
</html>
