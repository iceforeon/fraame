<x-app-layout>
  <div class="max-w-lg mx-auto sm:px-6 lg:px-8 mt-8">
    <div class="bg-white shadow-sm rounded-sm">
      <div class="p-4 sm:p-6 bg-white border-b border-gray-200">
        <div class="text-center">
          <h1 class="text-xl leading-6 font-medium text-gray-900">Log in</h1>
        </div>

        <div class="mt-6">
          <button type="submit" class="group relative w-full text-center px-4 py-2 bg-gray-800 border border-transparent font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 text-gray-200 group-hover:text-white" fill="currentColor">
                <path d="M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h1.5V2.14c-.326-.043-1.557-.14-2.857-.14C11.928 2 10 3.657 10 6.7v2.8H7v4h3V22h4v-8.5z" />
              </svg>
            </span>
            Continue with Facebook
          </button>
        </div>

        <div class="mt-7 relative">
          <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-gray-300"></div>
          </div>
          <div class="relative flex justify-center text-xs">
            <span class="px-2 bg-white text-gray-500">Or continue with</span>
          </div>
        </div>

        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}" class="mt-4">
          @csrf
          <div class="space-y-2">
            <div>
              <label for="username" class="text-sm font-semibold leading-6 text-gray-900">Username</label>
              <input type="text" name="username" id="username" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2" required maxlength="50">
            </div>

            <div>
              <label for="password" class="text-sm font-semibold leading-6 text-gray-900">Password</label>
              <input type="password" name="password" id="password" class="shadow-sm focus:ring-slate-500 focus:border-slate-500 block w-full sm:text-sm border-gray-300 rounded-sm mt-2" required maxlength="50">
            </div>
          </div>

          <div class="flex items-center justify-between flex-row-reverse mt-4">
            <div class="text-center ">
              <button type="submit" class="px-4 py-2 rounded-sm border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-gray-500">
                Log in
              </button>
            </div>
            <a href="{{ route('register') }}" class="uppercase text-xs hover:underline focus:underline tracking-wider focus:outline-none transition ease-in-out duration-150">Create an account</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
