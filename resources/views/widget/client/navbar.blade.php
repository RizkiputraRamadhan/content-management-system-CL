<!-- Navbar -->
<nav class="bg-white shadow-sm border-b border-gray-200 border-dashed">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between py-3">
        <div class="flex items-center space-x-2">
            <img src="{{ $meta->logo }}" alt="Kuli It Tecno" class="w-30 rounded-lg">
        </div>

        <div class="flex items-center space-x-3">

            <form action="/search" class="items-center  gap-x-2 lg:flex">
                <div class="w-full max-w-sm min-w-[200px]">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="absolute w-5 h-5 top-2.5 left-2.5 text-slate-600">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <input type="text" name="qr"
                            class="w-full pl-10 pr-3 py-2 bg-transparent placeholder:text-slate-400 text-slate-600 text-sm border border-slate-200 rounded-md transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow"
                            placeholder="Type here..." />
                    </div>
                </div>
                <button
                    class="rounded-md hidden cursor-pointer lg:block bg-blue-600 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-blue-700 focus:shadow-none active:bg-blue-700 hover:bg-blue-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                    type="submit">
                    Search
                </button>
            </form>

        </div>
    </div>
</nav>
