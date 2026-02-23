<nav x-data="{ open: false }" class="bg-white/70 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/" class="text-xl font-bold text-gray-800">
                       Transfercase Unlimited
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="/"
                       class="border-indigo-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Home
                    </a>
                    <p href="#"
                       class="text-gray-900 inline-flex items-center px-1 pt-1 text-sm font-medium">
                        Chevrolet
                    </p>
                    <p href="#"
                       class="text-gray-900 inline-flex items-center px-1 pt-1 text-sm font-medium">
                        Jeep
                    </p>
                    <p href="#"
                       class="text-gray-900 inline-flex items-center px-1 pt-1 text-sm font-medium">
                        Ford
                    </p>
                    <p href="#"
                       class="text-gray-900 inline-flex items-center px-1 pt-1 text-sm font-medium">
                        Ram
                    </p>

                    <a href="#contact" class="mt-2 mb-2 btn-italic py-3 px-4 text-center rounded bg-white font-medium text-orange-500
                hover:text-white hover:bg-orange-300 transition duration-200">Contact</a>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                    <span class="sr-only">Open main menu</span>
                    <!-- Hamburger icon -->
                    <svg x-show="!open" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <!-- Close icon -->
                    <svg x-show="open" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="open" @click.away="open = false" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="/"
               class="bg-indigo-50 border-indigo-500 text-indigo-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                Home
            </a>
            <a href="#"
               class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                Chevrolet
            </a>
            <a href="#"
               class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                Jeep
            </a>
            <a href="#"
               class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                Ford
            </a>
            <a href="#"
               class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                Ram
            </a>
            <a href="#contact"
               class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                Contact
            </a>
        </div>
    </div>
</nav>
