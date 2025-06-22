<nav class="mb-4 bg-white shadow-sm dark:bg-gray-900" x-data="{ open: false, userDropdown: false }">
    <div class="max-w-4xl px-4 mx-auto sm:px-6 xl:px-0">
        <div class="flex justify-between h-16">
            <!-- Logo/Brand -->
            <div class="flex items-center">
                <a href="{{ route('app') }}" class="text-xl font-bold text-indigo-600 dark:text-indigo-400">Tabungan</a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:ml-10 md:flex md:space-x-8 md:items-center">
                <a href="{{ route('app') }}"
                    class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('app') ? 'text-gray-900 dark:text-gray-100 border-b-2 border-indigo-500 dark:border-indigo-400' : 'text-gray-500 dark:text-gray-400 border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-700 dark:hover:text-gray-200' }}">
                    Beranda
                </a>
                <a href="{{ route('bills') }}"
                    class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('bills') ? 'text-gray-900 dark:text-gray-100 border-b-2 border-indigo-500 dark:border-indigo-400' : 'text-gray-500 dark:text-gray-400 border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-700 dark:hover:text-gray-200' }}">
                    Hutang
                </a>
                <a href="{{ route('savings') }}"
                    class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('savings') ? 'text-gray-900 dark:text-gray-100 border-b-2 border-indigo-500 dark:border-indigo-400' : 'text-gray-500 dark:text-gray-400 border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-700 dark:hover:text-gray-200' }}">
                    Celengan
                </a>

                <!-- Dark Mode Toggle -->
                <button @click="$store.darkMode.toggle()"
                    class="p-2 text-gray-500 rounded-full hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                    <svg x-show="!$store.darkMode.on" class="w-5 h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                        </path>
                    </svg>
                    <svg x-show="$store.darkMode.on" class="w-5 h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </button>

                <!-- User Dropdown -->
                <div class="relative ml-3" x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                        class="flex items-center text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                        <span>
                            {{ Auth::user()->username ??Str::of(Auth::user()->name)->before(' ')->whenEmpty(fn() => Auth::user()->name) }}
                        </span>
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
                        class="absolute right-0 z-10 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-800 dark:ring-gray-700">
                        <a href="{{ route('setting') }}"
                            class="flex items-center w-full gap-2 px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-4">
                                <path
                                    d="M18.75 12.75h1.5a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM12 6a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 6ZM12 18a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 18ZM3.75 6.75h1.5a.75.75 0 1 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM5.25 18.75h-1.5a.75.75 0 0 1 0-1.5h1.5a.75.75 0 0 1 0 1.5ZM3 12a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 3 12ZM9 3.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5ZM12.75 12a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0ZM9 15.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                            </svg>
                            Profil Saya
                        </a>
                        <hr class="border-gray-200 dark:border-gray-700">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full gap-2 px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
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
                <!-- Dark Mode Toggle (Mobile) -->
                <button @click="$store.darkMode.toggle()"
                    class="p-2 mr-2 text-gray-500 rounded-full hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                    <svg x-show="!$store.darkMode.on" class="w-5 h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                        </path>
                    </svg>
                    <svg x-show="$store.darkMode.on" class="w-5 h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </button>

                <button @click="open = !open" type="button"
                    class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
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
                class="block py-2 pl-3 pr-4 text-base font-medium {{ request()->routeIs('app') ? 'text-indigo-700 dark:text-indigo-400 border-l-4 border-indigo-500 dark:border-indigo-400 bg-indigo-50 dark:bg-gray-800' : 'text-gray-600 dark:text-gray-300 border-l-4 border-transparent hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-800 dark:hover:text-gray-100' }}">
                Beranda
            </a>
            <a href="{{ route('bills') }}"
                class="block py-2 pl-3 pr-4 text-base font-medium {{ request()->routeIs('bills') ? 'text-indigo-700 dark:text-indigo-400 border-l-4 border-indigo-500 dark:border-indigo-400 bg-indigo-50 dark:bg-gray-800' : 'text-gray-600 dark:text-gray-300 border-l-4 border-transparent hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-800 dark:hover:text-gray-100' }}">
                Hutang
            </a>
            <a href="{{ route('savings') }}"
                class="block py-2 pl-3 pr-4 text-base font-medium {{ request()->routeIs('savings') ? 'text-indigo-700 dark:text-indigo-400 border-l-4 border-indigo-500 dark:border-indigo-400 bg-indigo-50 dark:bg-gray-800' : 'text-gray-600 dark:text-gray-300 border-l-4 border-transparent hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-800 dark:hover:text-gray-100' }}">
                Celengan
            </a>
            <a href="{{ route('setting') }}"
                class="block py-2 pl-3 pr-4 text-base font-medium {{ request()->routeIs('setting') ? 'text-indigo-700 dark:text-indigo-400 border-l-4 border-indigo-500 dark:border-indigo-400 bg-indigo-50 dark:bg-gray-800' : 'text-gray-600 dark:text-gray-300 border-l-4 border-transparent hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-800 dark:hover:text-gray-100' }}">
                Profil Saya
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex items-center w-full gap-2 py-2 pl-3 pr-4 text-base font-medium text-gray-600 border-l-4 border-transparent dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-800 dark:hover:text-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>
                    Logout
                </button>
            </form>
            <p class="block py-1 text-sm text-center text-gray-600 dark:text-gray-300">
                Kamu login sebagai
                <span class="text-indigo-500 dark:text-indigo-400">
                    {{ Auth::user()->username ??Str::of(Auth::user()->name)->before(' ')->whenEmpty(fn() => Auth::user()->name) }}
                </span>
            </p>
        </div>
    </div>
</nav>
