<div>
  <pre class="mb-4">{{ $errors }}</pre>
  <form wire:submit.prevent="save" class="divide-y divide-gray-200">
    <div class="space-y-4">
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label for="name" class="text-sm font-semibold leading-6 text-gray-900">Name</label>
          <input wire:model.lazy="user.name" type="text" name="name" id="name" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2">
        </div>

        <div>
          <label for="username" class="text-sm font-semibold leading-6 text-gray-900">Username</label>
          <input wire:model.lazy="user.username" type="text" name="username" id="username" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2">
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label for="email" class="text-sm font-semibold leading-6 text-gray-900">Email</label>
          <input wire:model.lazy="user.email" type="email" name="email" id="email" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2">
        </div>

        <div>
          <label for="password" class="text-sm font-semibold leading-6 text-gray-900">Password</label>
          <input wire:model.defer="user.password" type="password" name="password" id="password" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2">
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label for="name" class="text-sm font-semibold leading-6 text-gray-900">Role</label>
          <select wire:model.lazy="user.role" name="category" id="category" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2">
            @foreach (\App\Enums\Role::cases() as $role)
            <option value="{{ $role->value }}">{{ $role->name }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label for="status" class="text-sm font-semibold leading-6 text-gray-900">Status</label>
          <select wire:model.lazy="user.status" name="status" id="status" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2">
            <option value="1" {{ (boolean) $user->status == true ? 'selected' : null  }}>Active</option>
            <option value="0" {{ (boolean) $user->status == false ? 'selected' : null  }}>Inactive</option>
          </select>
        </div>
      </div>

      <div>
        <label for="description" class="text-sm font-semibold leading-6 text-gray-900">Description</label>
        <textarea wire:model.lazy="user.description" name="description" id="description" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2" rows="3"></textarea>
      </div>
    </div>

    <div @class([ 'flex items-center mt-6 pt-4' , 'justify-end'=> ! $hashid,
      'justify-between' => $hashid])>
      @if ($hashid)
      <button wire:click="delete" type="button" class="text-gray-900 font-semibold text-xs uppercase hover:underline focus:underline focus:outline-none tracking-widest transition ease-in-out duration-150" tabindex="-1">
        Delete
      </button>
      @endif
      <x-button>
        Save
      </x-button>
    </div>
  </form>
</div>
