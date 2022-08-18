<x-dashboard-layout>
  <div class="py-10">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
      <div class="bg-white shadow-sm sm:rounded-sm">
        <div class="p-6 bg-white border-b border-gray-200 space-y-8">
          <livewire:settings.profile />
        </div>
      </div>

      <div class="bg-white shadow-sm sm:rounded-sm">
        <div class="p-6 bg-white border-b border-gray-200 space-y-8">
          <livewire:settings.password />
        </div>
      </div>

      <div class="bg-white shadow-sm sm:rounded-sm">
        <div class="p-6 bg-white border-b border-gray-200 space-y-8">
          <livewire:settings.delete />
        </div>
      </div>
    </div>
  </div>
</x-dashboard-layout>
