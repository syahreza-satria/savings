<nav class="mb-4 bg-white shadow-sm" x-data="{ open: false, userDropdown: false }">
    <div class="max-w-4xl px-4 mx-auto sm:px-6 xl:px-0">
        <div class="flex justify-between h-16">
            <!-- Logo/Brand -->
            <div class="flex items-center">
                <a href="{{ route('app') }}" class="text-xl font-bold text-indigo-600">Tabungan</a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:ml-10 md:flex md:space-x-8 md:items-center">
                <a href="{{ route('app') }}"
                    class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('app') ? 'text-gray-900 border-b-2 border-indigo-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300 hover:text-gray-700' }}">
                    Beranda
                </a>
                <a href="{{ route('bills') }}"
                    class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('bills') ? 'text-gray-900 border-b-2 border-indigo-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300 hover:text-gray-700' }}">
                    Hutang
                </a>
                <a href="{{ route('savings') }}"
                    class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('savings') ? 'text-gray-900 border-b-2 border-indigo-500' : 'text-gray-500 border-b-2 border-transparent hover:border-gray-300 hover:text-gray-700' }}">
                    Celengan
                </a>

                <!-- User Dropdown -->
                <div class="relative ml-3" x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                        class="flex items-center text-sm text-gray-500 hover:text-gray-700 focus:outline-none">
                        <span class="mr-1">{{ Str::words(auth()->user()->name, 1, '') }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 z-10 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full gap-2 px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center -mr-2 md:hidden">
                <button @click="open = !open" type="button"
                    class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                    aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg x-show="!open" class="block w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" class="block w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="open" class="md:hidden" x-transition>
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('app') }}"
                class="block py-2 pl-3 pr-4 text-base font-medium {{ request()->routeIs('app') ? 'text-indigo-700 border-l-4 border-indigo-500 bg-indigo-50' : 'text-gray-600 border-l-4 border-transparent hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                Beranda
            </a>
            <a href="{{ route('bills') }}"
                class="block py-2 pl-3 pr-4 text-base font-medium {{ request()->routeIs('bills') ? 'text-indigo-700 border-l-4 border-indigo-500 bg-indigo-50' : 'text-gray-600 border-l-4 border-transparent hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                Hutang
            </a>
            <a href="{{ route('savings') }}"
                class="block py-2 pl-3 pr-4 text-base font-medium {{ request()->routeIs('savings') ? 'text-indigo-700 border-l-4 border-indigo-500 bg-indigo-50' : 'text-gray-600 border-l-4 border-transparent hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
                Celengan
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex items-center w-full gap-2 py-2 pl-3 pr-4 text-base font-medium text-gray-600 border-l-4 border-transparent hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>
                    Logout
                </button>
            </form>
            <a href="{{ route('savings') }}" class="block py-2 pl-3 pr-4 text-lg text-center">
                {{ Auth::user()->name }}
            </a>
        </div>
    </div>
</nav>
