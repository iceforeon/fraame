<x-app-layout>
  <div class="py-10">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm">
        <div class="p-6 bg-white border-b border-gray-200">
          <livewire:posts.form :hashid="$hashid" />
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
