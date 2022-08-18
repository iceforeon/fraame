<div>
  <form wire:submit.prevent="delete">
    <pre class="mb-4">{{ $errors }}</pre>
    <h3 class="text-lg leading-6 font-medium text-gray-900">Delete Account</h3>
    <div class="mt-4 space-y-4">
      <div class="space-y-2">
        <p>Once your account is deleted, all its resources and data will also be deleted.</p>
      </div>
      <div>
        <label for="username" class="text-sm font-semibold leading-6 text-gray-900">Username</label>
        <input wire:model.defer="username" type="text" name="username" id="name" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2" required maxlength="50">
      </div>
      <div class="flex justify-end">
        <button type="submit" class="min-w-[165px] text-center px-4 py-2 bg-red-600 border border-transparent font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-700 focus:outline-none focus:border-red-600 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150 focus:z-20">Delete Account</button>
      </div>
    </div>
  </form>
</div>
