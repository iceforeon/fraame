<div>
  <div class="bg-white overflow-hidden shadow-sm mt-4">
    <div class="p-6 bg-white border-b border-gray-200">
      <div>
        <div class="flex item-center justify-between">
          <div class="sm:w-1/2 lg:w-1/3">
            <input wire:model.debounce.500ms="filename" type="text" name="filename" id="filename" class="shadow-sm focus:ring-gray-500 focus:border-gray-500 block w-full sm:text-sm border-gray-300 placeholder:text-slate-400 placeholder:text-xs placeholder:tracking-wide" placeholder="SEARCH BY FILENAME">
          </div>

          <div class="flex items-center justify-center space-x-5">
            <a href="{{ route('spreadsheets.scrape') }}" class="hidden sm:inline-block text-gray-900 text-xs uppercase hover:underline focus:underline focus:outline-none tracking-widest transition ease-in-out duration-150 font-semibold">Scrape</a>

            <a href="{{ route('spreadsheets.upload') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
              Upload
            </a>
          </div>
        </div>

        <div class="mt-6 flex flex-col space-y-4">
          <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
              <div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5">
                <table class="min-w-full divide-y divide-gray-300">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                        Filename
                      </th>

                      <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 whitespace-nowrap">
                        Imported At
                      </th>

                      <th></th>
                    </tr>
                  </thead>

                  <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($spreadsheets as $spreadsheet)
                    <tr>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        <a href="{{ $spreadsheet->url }}" target="_blank" download class="text-sm hover:underline focus:underline focus:outline-none truncate">
                          {{ $spreadsheet->filename_formatted }}
                        </a>
                      </td>

                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        {{ $spreadsheet->imported_at_for_human }}
                      </td>

                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        <div class="flex items-center justify-end divide-x divide-gray-200">
                          <button wire:click="import('{{ $spreadsheet->hashid }}')" type="button" class="text-gray-900 font-semibold text-xs uppercase hover:underline focus:underline focus:outline-none tracking-widest transition ease-in-out duration-150">
                            Import</span>
                          </button>
                          <button wire:click="delete('{{ $spreadsheet->hashid }}')" type="button" class="text-gray-900 font-semibold text-xs uppercase hover:underline focus:underline focus:outline-none tracking-widest transition ease-in-out duration-150 ml-3 pl-3">
                            Delete
                          </button>
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
            {{ $spreadsheets->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
