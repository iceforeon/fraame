<div>
  <div class="flex item-center justify-between">
    <div class="sm:w-1/2 lg:w-1/3">
      <input wire:model.debounce.500ms="title" type="text" name="title" id="title" class="shadow-sm focus:ring-gray-500 focus:border-gray-500 block w-full sm:text-sm border-gray-300 placeholder:text-slate-400 placeholder:text-xs placeholder:tracking-wide" placeholder="SEARCH BY TITLE">
    </div>

    <div>
      <button wire:click="import" type="button" class="inline-flex items-center justify-center border border-transparent bg-white px-4 py-2 text-sm font-medium text-black hover:underline focus:outline-none sm:w-auto">
        <span wire:loading.remove wire:target="import">Import</span>
        <span wire:loading wire:target="import">Importing...</span>
      </button>

      <a href="{{ route('movies.create') }}" class="inline-flex items-center justify-center border border-transparent bg-gray-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 sm:w-auto">
        New Movie
      </a>
    </div>
  </div>

  <div class="mt-6 flex flex-col space-y-4">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5">
          <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                  Title
                </th>

                <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                  Genres
                </th>

                <th></th>
              </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">
              @forelse ($movies as $movie)
              <tr>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500" data-rank="{{ $movie->imdb_rank }}">
                  <a href="/movie/{{ $movie->tmdb_id }}" class="hover:underline">
                    {{ $movie->title_formatted }}
                  </a>
                </td>

                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                  {{ $movie->genres }}
                </td>

                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                  <div class="flex justify-end items-center space-x-3">
                    <a href="{{ route('movies.edit', $movie->hashid) }}" class="text-gray-400 hover:text-gray-600">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                      </svg>
                    </a>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td class="text-center w-full">---</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div>
      {{ $movies->links() }}
    </div>
  </div>
</div>
