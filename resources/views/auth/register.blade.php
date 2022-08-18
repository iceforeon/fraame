<x-app-layout>
  <div class="max-w-lg mx-auto sm:px-6 lg:px-8 mt-8">
    <div class="bg-white shadow-sm sm:rounded-sm">
      <div class="p-4 sm:p-6 bg-white border-b border-gray-200 space-y-6">
        <div class="text-center">
          <h1 class="text-xl leading-6 font-medium text-gray-900">Register</h1>
        </div>
        <div>
          <button type="submit" class="group relative w-full text-center px-4 py-2 bg-gray-800 border border-transparent font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 text-gray-200 group-hover:text-white" fill="currentColor">
                <path d="M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h1.5V2.14c-.326-.043-1.557-.14-2.857-.14C11.928 2 10 3.657 10 6.7v2.8H7v4h3V22h4v-8.5z" />
              </svg>
            </span>
            Continue with Facebook
          </button>
        </div>
        <div class="text-center text-xs">
          <p>By clicking the "Continue with Facebook" button.</p>
          <p>I agree to {{ config('app.name') }}'s <a href="{{ route('terms') }}" class="font-bold hover:underline focus:underline focus:outline-none">Terms of Service</a> and <a href="{{ route('privacy') }}" class="font-bold hover:underline focus:underline focus:outline-none">Privacy Policy</a>.</p>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
