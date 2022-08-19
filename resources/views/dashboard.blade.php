<x-dashboard-layout>
  <div class="py-6 sm:py-8">
    <div class="max-w-6xl mx-auto px-6 lg:px-8">
      <div>
        <h3 class="text-lg leading-6 font-medium text-gray-900">Stats</h3>
        <dl class="mt-4 grid grid-cols-1 gap-5 sm:grid-cols-4">
          <livewire:movies.stats />

          <livewire:tv-shows.stats />

          <livewire:animes.stats />

          <livewire:users.stats />
        </dl>
      </div>

      <div class="sm:grid grid-cols-2 gap-5 mt-5 space-y-5 sm:space-y-0">
        <div>
          <div class="flex items-center justify-between">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Featured Today</h3>
          </div>
          <div class="bg-white shadow-sm overflow-hidden rounded-sm mt-4">
              <livewire:dashboard.featured-today />
          </div>
        </div>
        <div>
          <div class="flex items-center justify-between">
            <h3 class="text-lg leading-6 font-medium text-gray-900">User Activity</h3>
            <a href="" class="text-gray-900 text-xs uppercase hover:underline focus:underline focus:outline-none tracking-widest transition ease-in-out duration-150 font-semibold">View All</a>
          </div>
          <div class="bg-white shadow-sm overflow-hidden rounded-sm mt-4">
              <div class="px-4">
                <ul role="list" class="divide-y divide-gray-200">
                  <li class="py-4">
                    <div class="flex">
                      <div class="flex-1 space-y-1">
                        <div class="flex items-center justify-between">
                          <h3 class="text-sm font-medium">Lindsay Walton</h3>
                          <p class="text-sm text-gray-500">1h</p>
                        </div>
                        <p class="text-sm text-gray-500">Added Logan (2017) in Movies</p>
                      </div>
                    </div>
                  </li>
                  <li class="py-4">
                    <div class="flex">
                      <div class="flex-1 space-y-1">
                        <div class="flex items-center justify-between">
                          <h3 class="text-sm font-medium">Lindsay Walton</h3>
                          <p class="text-sm text-gray-500">1h</p>
                        </div>
                        <p class="text-sm text-gray-500">Added Apocalypto (2006) in Movies</p>
                      </div>
                    </div>
                  </li>
                  <li class="py-4">
                    <div class="flex">
                      <div class="flex-1 space-y-1">
                        <div class="flex items-center justify-between">
                          <h3 class="text-sm font-medium">Lindsay Walton</h3>
                          <p class="text-sm text-gray-500">1h</p>
                        </div>
                        <p class="text-sm text-gray-500">Added Black Panther (2018) in Movies</p>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
          </div>
        </div>
      </div>

      <div class="mt-5">
        <div>
          <h3 class="text-lg leading-6 font-medium text-gray-900">Spreadsheets</h3>
        </div>

        <livewire:spreadsheets.table />
      </div>
    </div>
  </div>
</x-dashboard-layout>
