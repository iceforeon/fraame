<x-app-layout>
  <div class="py-6 sm:py-8">
    <div class="max-w-6xl mx-auto px-6 lg:px-8">
      <div>
        <h3 class="text-lg leading-6 font-medium text-gray-900">Stats</h3>
        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
          <livewire:movies.stats />

          <livewire:tv-shows.stats />

          <livewire:animes.stats />

          <livewire:users.stats />
        </dl>
      </div>

      <div>
        <div class="mt-5">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Spreadsheets</h3>
        </div>

        <livewire:spreadsheets.table />
      </div>
    </div>
  </div>
</x-app-layout>
