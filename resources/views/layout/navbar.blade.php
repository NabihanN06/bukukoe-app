<div class="flex justify-between items-center px-6 py-4 bg-blue-800 border-b-2 border-gray-100">
    {{-- Logo --}}
    <a href="/" class="font-bold text-3xl text-white hover:text-gray-300 transition-colors duration-200">
        BUKUKOE
    </a>

    {{-- Navigations --}}
    <nav class="flex gap-4 items-center">
        @auth            
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-black font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span class="font-medium hidden md:block text-white">{{ auth()->user()->name }}</span>
                </div>
                
                <form action={{route('logout')}} method="POST">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 bg-red-500 text-white rounded hover:bg-red-600 transition-colors duration-200">
                        Logout
                    </button>
                </form>
            </div>
        @else
            <a href={{route('sign-in-form')}} class="px-4 py-2 bg-gray-100 text-black rounded hover:bg-gray-200 transition-colors duration-200">
                Sign In
            </a>
            <a href={{route('sign-up-form')}} class="px-4 py-2 bg-gray-100 text-black rounded hover:bg-gray-200 transition-colors duration-200">
                Sign Up
            </a>
        @endauth
    </nav>
</div>
