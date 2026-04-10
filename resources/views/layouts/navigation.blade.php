<header class="bg-gray-200 px-6 py-3 flex items-center justify-between">
    {{-- Logo --}}
    <a href="{{ route('dashboard') }}">
        <img src="{{ asset('images/logo.png') }}" alt="SmartRentBD" class="h-14"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
        <span style="display:none" class="text-blue-800 font-extrabold text-xl">SmartRent<span class="text-orange-400">BD</span></span>
    </a>

    {{-- Right buttons --}}
    <div class="flex items-center gap-3">
        @auth
            <a href="{{ route('owner.properties.create') }}"
               class="bg-gray-800 text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-gray-700">
                + Add Property
            </a>
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                    class="bg-gray-800 text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-gray-700">
                    {{ Auth::user()->name }} ▾
                </button>
                <div x-show="open" @click.away="open = false"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-50 py-2">
                    <a href="{{ route('profile.edit') }}"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}"
               class="bg-gray-800 text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-gray-700">
                Login/Register
            </a>
        @endauth
    </div>
</header>

{{-- Purple Nav Bar --}}
<nav class="bg-indigo-300 px-6 py-3 flex items-center justify-between">
    <div class="flex gap-4">
        <a href="{{ route('dashboard') }}"
           class="border border-gray-400 text-gray-800 px-5 py-1.5 rounded-full text-sm font-medium hover:bg-white transition
           {{ request()->routeIs('dashboard') ? 'bg-white' : '' }}">
            Home
        </a>
        <a href="{{ route('properties.index') }}"
           class="border border-orange-400 text-orange-500 px-5 py-1.5 rounded-full text-sm font-medium hover:bg-white transition
           {{ request()->routeIs('properties.index') ? 'bg-white' : '' }}">
            Property listing
        </a>
        <a href="{{ route('profile.edit') }}"
           class="border border-orange-400 text-orange-500 px-5 py-1.5 rounded-full text-sm font-medium hover:bg-white transition
           {{ request()->routeIs('profile.*') ? 'bg-white' : '' }}">
            Profile
        </a>
    </div>

    <a href="{{ route('properties.search') }}"
       class="border border-orange-400 text-orange-500 px-6 py-1.5 rounded-full text-sm font-medium hover:bg-white transition
       {{ request()->routeIs('properties.search') ? 'bg-white' : '' }}">
        Search
    </a>
</nav>