<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 sticky top-0 z-[150]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <div class="flex items-center gap-8">
                    <x-institutional-topbar />

                <a href="{{ url('/') }}" class="font-semibold text-slate-900 tracking-tight">
                    Emploi de temps 
                </a>

                <div class="hidden md:flex items-center space-x-1">
                    @can('admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">Tableau de bord</x-nav-link>
                        <x-nav-link :href="route('seances.index')" :active="request()->routeIs('seances.*')">Séances</x-nav-link>
                        <x-nav-link :href="route('groupes.index')" :active="request()->routeIs('groupes.*')">Groupes</x-nav-link>
                        <x-nav-link :href="route('formateurs.index')" :active="request()->routeIs('formateurs.*')">Formateurs</x-nav-link>
                        <x-nav-link :href="route('salles.index')" :active="request()->routeIs('salles.*')">Salles</x-nav-link>
                    @elsecan('formateur')
                        <x-nav-link :href="route('formateur.dashboard')" :active="request()->routeIs('formateur.dashboard')">Mon Planning</x-nav-link>
                    @elsecan('stagiaire')
                        <x-nav-link :href="route('stagiaire.dashboard')" :active="request()->routeIs('stagiaire.dashboard')">Mon EDT</x-nav-link>
                    @endcan
                </div>
            </div>

            <div class="hidden md:flex items-center gap-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 text-sm font-semibold text-slate-700 hover:text-blue-600 transition-colors focus:outline-none">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="py-1">
                            @cannot('stagiaire')
                                <x-dropdown-link :href="route('profile.edit')">Mon profil</x-dropdown-link>
                            @endcannot
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Déconnexion
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <button @click="open = !open" class="md:hidden p-2 rounded-md text-slate-500 hover:text-blue-600 hover:bg-blue-50 focus:outline-none">
                <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'block': !open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path :class="{'hidden': !open, 'block': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <div x-show="open" x-collapse class="md:hidden border-t border-slate-200 bg-white">
        <div class="px-4 py-3 space-y-1">
            
            @can('admin')
                <x-responsive-nav-link :href="route('admin.dashboard')">Tableau de bord</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('seances.index')">Séances</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('groupes.index')">Groupes</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('formateurs.index')">Formateurs</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('salles.index')">Salles</x-responsive-nav-link>
            @elsecan('formateur')
                <x-responsive-nav-link :href="route('formateur.dashboard')">Mon Planning</x-responsive-nav-link>
            @elsecan('stagiaire')
                <x-responsive-nav-link :href="route('stagiaire.dashboard')">Mon EDT</x-responsive-nav-link>
            @endcan
        </div>
        <div class="border-t border-slate-200 px-4 py-4 bg-slate-50">
            <div class="flex items-center gap-3 px-3 mb-3">
                <div class="w-8 h-8 rounded bg-blue-600 flex items-center justify-center text-white text-xs font-bold">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <div class="space-y-1">
                @cannot('stagiaire')
                    <x-responsive-nav-link :href="route('profile.edit')">Profil</x-responsive-nav-link>
                @endcannot
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Déconnexion
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>