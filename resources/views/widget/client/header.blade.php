@if ($menu->count() > 0)
    <header
        class="w-full mx-auto bg-white bg-opacity-90 sticky top-0 shadow backdrop-blur-lg backdrop-saturate-150 z-[9999]">
        <!-- Scrollable Menu -->
        <nav class="flex overflow-x-auto whitespace-nowrap px-4 py-2 relative z-10 custom-scrollbar-x">
            @php
                $parents = $menu->where('type_1', 'parent');
                $menuItems = $menu->groupBy('parent_id');
            @endphp

            @foreach ($parents as $parent)
                @php
                    $hasSubmenus = ($menuItems[$parent->id] ?? collect())->count() > 0;
                @endphp

                <a href="{{ $parent->type_2 == 'page' ? url('page/' . $parent->slug) : url($parent->slug) }}"
                    data-target="dropdown{{ $parent->id }}"
                    class="dropdown-btn flex items-center {{ $hasSubmenus ? 'parent-link' : '' }}  text-sm px-4 py-2 text-gray-700 cursor-pointer font-semibold hover:text-blue-600 focus:outline-none relative">
                    {{ $parent->name }}
                    @if ($hasSubmenus)
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    @endif
                </a>
            @endforeach
        </nav>


        @foreach ($parents as $parent)
            @php
                $submenus = $menuItems[$parent->id] ?? collect();
            @endphp

            @if ($submenus->count())
                <div id="dropdown{{ $parent->id }}" class="hidden absolute bg-white shadow-lg rounded-md w-40 z-50">
                    @foreach ($submenus as $submenu)
                        <a href="{{ $submenu->type_2 == 'page' ? url('page/' . $submenu->slug) : url($submenu->slug) }}"
                            class="block px-4 py-4 text-sm text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors duration-200 whitespace-normal">
                            {{ $submenu->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        @endforeach
    </header>

    @push('scripts')
        <script>
            const dropdownButtons = document.querySelectorAll('.dropdown-btn');
            const dropdownMenus = document.querySelectorAll('[id^="dropdown"]');

            dropdownButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const target = button.getAttribute('data-target');

                    dropdownMenus.forEach(menu => {
                        if (menu.id === target) {
                            menu.classList.toggle('hidden');
                            const rect = button.getBoundingClientRect();
                            menu.style.left = rect.left + 'px';
                        } else {
                            menu.classList.add('hidden');
                        }
                    });
                });
            });

            window.addEventListener('click', () => {
                dropdownMenus.forEach(menu => menu.classList.add('hidden'));
            });

            document.addEventListener('DOMContentLoaded', function() {
                const parentLinks = document.querySelectorAll('.parent-link');

                parentLinks.forEach(link => {
                    let clickCount = 0;
                    let timeout;

                    link.addEventListener('click', function(e) {
                        clickCount++;

                        if (clickCount === 1) {
                            e.preventDefault();
                            timeout = setTimeout(() => {
                                clickCount = 0;
                            }, 300);
                        } else if (clickCount === 2) {
                            e.preventDefault();
                            clearTimeout(timeout);
                            clickCount = 0;
                            window.location.href = this.getAttribute('href');
                        }
                    });
                });
            });
        </script>
    @endpush
@endif
