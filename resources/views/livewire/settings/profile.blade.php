<div>
  <form wire:submit.prevent="update">
    <pre class="mb-4">{{ $errors }}</pre>
    <h3 class="text-lg leading-6 font-medium text-gray-900">Profile Settings</h3>
    <div class="mt-4 space-y-4">
      <div>
        <label for="name" class="text-sm font-semibold leading-6 text-gray-900">Name</label>
        <input wire:model.defer="name" type="text" name="title" id="name" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2" required maxlength="50">
      </div>

      <div>
        <label for="username" class="text-sm font-semibold leading-6 text-gray-900">Username</label>
        <input wire:model.defer="username" type="text" name="username" id="username" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2" required maxlength="25">
      </div>

      <div>
        <label for="email" class="text-sm font-semibold leading-6 text-gray-900">Email</label>
        <input wire:model.defer="email" type="email" name="email" id="email" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2" required maxlength="25">
      </div>

      <div>
        <label for="description" class="text-sm font-semibold leading-6 text-gray-900">Description</label>
        <textarea wire:model.defer="description" name="description" id="description" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2 min-h-[58px]" maxlength="255"></textarea>
      </div>
    </div>
    <div class="mt-4 flex justify-end">
      <button type="submit" class="min-w-[165px] text-center px-4 py-2 bg-gray-800 border border-transparent font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Update Profile</button>
    </div>
  </form>
</div>
