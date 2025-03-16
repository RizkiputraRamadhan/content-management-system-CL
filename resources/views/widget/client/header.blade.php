@if ($menu->count() > 0)
    <header
        class="block w-full px-4 py-2 mx-auto bg-white bg-opacity-90 sticky top-0 shadow lg:px-8 lg:py-3 backdrop-blur-lg backdrop-saturate-150 z-[9999]">
        <div class="flex flex-wrap items-center justify-between mx-auto text-slate-800">
            <div class="block w-full z-[10000]">
                <ul
                    class="flex gap-2 mt-2 mb-4 lg:mb-0 lg:mt-0 lg:items-center lg:gap-6 whitespace-nowrap custom-scrollbar-dropdown-menu">
                    @php
                        $menuItems = $menu->groupBy('parent_id');
                        $parents = $menu->where('type_1', 'parent');
                    @endphp

                    @foreach ($parents as $parent)
                        @php
                            $submenus = $menuItems[$parent->id] ?? collect();
                            $hasSubmenus = $submenus->count() > 0;
                        @endphp

                        <li class="relative flex items-center p-1 text-sm gap-x-2 text-slate-600 group z-[10000]">
                            @if ($hasSubmenus)
                                <div class="relative">
                                    <a href="{{ $parent->type_2 == 'page' ? url('page/' . $parent->slug) : url($parent->slug) }}"
                                        class="flex items-center hover:text-slate-900 transition-colors duration-200">
                                        {{ $parent->name }}
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </a>
                                    
                                    <div class="absolute left-0 top-full w-48 min-w-fit max-w-xs hidden group-hover:flex flex-col bg-white shadow-lg rounded-lg py-2 z-[10001] dropdown-menu">
                                        @foreach ($submenus as $submenu)
                                            <a href="{{ $submenu->type_2 == 'page' ? url('page/' . $submenu->slug) : url($submenu->slug) }}"
                                               class="block px-4 py-2 text-sm text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors duration-200 whitespace-normal">
                                                {{ $submenu->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a href="{{ $parent->type_2 == 'page' ? url('page/' . $parent->slug) : url($parent->slug) }}"
                                    class="flex items-center hover:text-slate-900 transition-colors duration-200">
                                    {{ $parent->name }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </header>
@endif

@push('styles')
    <style>
        .dropdown-menu {
            opacity: 0;
            z-index: 99999;
            visibility: hidden;
            transform: translateY(-10px);
            transition: opacity 0.3s ease-in-out, visibility 0s linear 0.5s, transform 0.3s ease-in-out;
        }

        .group:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            transition: opacity 0.3s ease-in-out, visibility 0s linear 0s, transform 0.3s ease-in-out;
            display: flex;
        }

        .group {
            position: relative;
        }

        @media (max-width: 768px) {
            .group:hover .dropdown-menu {
                display: none;
            }
        }

        .custom-scrollbar-dropdown-menu {
            overflow-x: hidden;
            transition: overflow 0.3s ease-in-out;
        }

        .custom-scrollbar-dropdown-menu:hover {
            overflow-x: auto;
        }

        .custom-scrollbar-dropdown-menu::-webkit-scrollbar {
            height: 6px;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .custom-scrollbar-dropdown-menu:hover::-webkit-scrollbar {
            opacity: 1;
        }

        .custom-scrollbar-dropdown-menu::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar-dropdown-menu::-webkit-scrollbar-thumb {
            background: #dfdfdf;
            border-radius: 10px;
        }

        .custom-scrollbar-dropdown-menu::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
@endpush
