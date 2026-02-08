<nav x-data="{ open: false, userMenu: false }" class="border-b border-gray-200 bg-white/80 backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            {{-- Left --}}
            <div class="flex items-center gap-6">
                {{-- Brand --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-600 text-white font-bold text-sm shadow">
                        MF
                    </div>
                    <div class="hidden sm:block leading-tight">
                        <p class="text-sm font-semibold text-gray-900">Ministère des Finances</p>
                        <p class="text-xs text-gray-500">Gestion des pannes</p>
                    </div>
                </a>

                @php
                    $role = Auth::user()->role ?? 'utilisateur';
                    $isStaff = in_array($role, ['admin', 'technicien']);
                    $isAdmin = ($role === 'admin');
                @endphp

                {{-- Links (Desktop) --}}
                <div class="hidden md:flex items-center gap-2">
                    <a href="{{ route('dashboard') }}"
                       class="px-3 py-2 rounded-lg text-sm font-semibold
                       {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('pannes.index') }}"
                       class="px-3 py-2 rounded-lg text-sm font-semibold
                       {{ request()->routeIs('pannes.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        Pannes
                    </a>

                    @if($isStaff)
                        <a href="{{ route('interventions.index') }}"
                           class="px-3 py-2 rounded-lg text-sm font-semibold
                           {{ request()->routeIs('interventions.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            Interventions
                        </a>
                    @endif

                    @if($isAdmin)
                        <a href="{{ route('techniciens.index') }}"
                           class="px-3 py-2 rounded-lg text-sm font-semibold
                           {{ request()->routeIs('techniciens.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            Techniciens
                        </a>
                    @endif
                </div>
            </div>

            {{-- Right (Desktop) --}}
            <div class="hidden md:flex items-center gap-3">
                <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                    {{ $role }}
                </span>

                {{-- ✅ Custom dropdown (fix transparency/z-index issue) --}}
                <div class="relative" x-data>
                    <button
                        type="button"
                        @click="userMenu = !userMenu"
                        @keydown.escape.window="userMenu = false"
                        class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-xs font-bold text-gray-700">
                            {{ strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}
                        </span>
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    {{-- Backdrop click --}}
                    <div x-show="userMenu" x-cloak @click="userMenu = false" class="fixed inset-0 z-40"></div>

                    {{-- Menu --}}
                    <div
                        x-show="userMenu"
                        x-cloak
                        x-transition:enter="transition ease-out duration-120"
                        x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                        class="absolute right-0 mt-2 w-56 rounded-xl bg-white shadow-xl ring-1 ring-black/5 z-50 overflow-hidden"
                    >
                        <div class="px-4 py-3 border-b border-gray-100">
                            <div class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                        </div>

                        <div class="py-1">
                            <a href="{{ route('profile.edit') }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                Profile
                            </a>

                            <a href="{{ route('pannes.index') }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                Mes pannes
                            </a>

                            @if($isStaff)
                                <a href="{{ route('interventions.index') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    Interventions
                                </a>
                            @endif

                            @if($isAdmin)
                                <a href="{{ route('techniciens.index') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    Techniciens
                                </a>
                            @endif
                        </div>

                        <div class="border-t border-gray-100"></div>

                        <form method="POST" action="{{ route('logout') }}" class="py-1">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Hamburger (Mobile) --}}
            <div class="md:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center rounded-lg p-2 text-gray-500 hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-cloak class="md:hidden border-t border-gray-200 bg-white">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('dashboard') }}"
               class="block rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}">
                Dashboard
            </a>

            <a href="{{ route('pannes.index') }}"
               class="block rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs('pannes.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}">
                Pannes
            </a>

            @if($isStaff)
                <a href="{{ route('interventions.index') }}"
                   class="block rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs('interventions.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    Interventions
                </a>
            @endif

            @if($isAdmin)
                <a href="{{ route('techniciens.index') }}"
                   class="block rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs('techniciens.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    Techniciens
                </a>
            @endif

            <div class="mt-3 border-t pt-3">
                <div class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</div>
                <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>

                <div class="mt-2">
                    <a href="{{ route('profile.edit') }}" class="block rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                        Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left rounded-lg px-3 py-2 text-sm text-red-600 hover:bg-red-50">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</nav>