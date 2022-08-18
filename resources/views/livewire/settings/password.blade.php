<div class="border-t border-gray-200 pt-6">
  <form wire:submit.prevent="update">
    <pre class="mb-4">{{ $errors }}</pre>
    <h3 class="text-lg leading-6 font-medium text-gray-900">Password Settings</h3>
    <div class="mt-4 space-y-4">
      @unless (request()->user()->hasPassword())
      <p>If you add a password to your account you can either sign in using your facebook account or with your username and password.</p>
      @endunless

      @if (request()->user()->hasPassword())
      <div>
        <label for="current_password" class="text-sm font-semibold leading-6 text-gray-900">Current Password</label>
        <input wire:model.defer="current_password" type="password" name="current_password" id="current_password" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2" maxlength="60">
      </div>
      @endif

      <div>
        <label for="password" class="text-sm font-semibold leading-6 text-gray-900">Password</label>
        <input wire:model.defer="password" type="password" name="password" id="password" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2" maxlength="60">
      </div>

      <div>
        <label for="password_confirmation" class="text-sm font-semibold leading-6 text-gray-900">Confirm Password</label>
        <input wire:model.defer="password_confirmation" type="password" name="password_confirmation" id="password_confirmation" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2" maxlength="60">
      </div>

      <div class="mt-4 flex justify-end">
        <button type="submit" class="min-w-[165px] text-center px-4 py-2 bg-gray-800 border border-transparent font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Update Password</button>
      </div>
    </div>
  </form>
</div>
