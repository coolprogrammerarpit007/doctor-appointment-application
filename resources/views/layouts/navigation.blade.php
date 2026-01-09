<nav x-data="{ open: false }" class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Left Section -->
            <div class="flex items-center space-x-8">

                <!-- Logo -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                    <x-application-logo class="h-9 w-auto text-gray-800" />
                </a>

                <!-- Desktop Nav Links -->
                <div class="hidden sm:flex space-x-6">
                    <x-nav-link
                        :href="route('admin.dashboard')"
                        :active="request()->routeIs('admin.dashboard')">
                        Dashboard
                    </x-nav-link>

                    <x-nav-link
                        :href="route('admin.appointments.index')"
                        :active="request()->routeIs('admin.appointments.*')">
                        Medical Appointments
                    </x-nav-link>
                </div>
            </div>

            <!-- Right Section (User Dropdown) -->
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">

                    <!-- Dropdown Trigger -->
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-600 hover:text-gray-800">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-2 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293L10 10.586l4.707-3.293 1.414 1.414-6.121 4.293a1 1 0 01-1.414 0L3.879 8.707z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </x-slot>

                    <!-- Dropdown Content -->
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 text-gray-500 hover:text-gray-700">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" class="sm:hidden border-t border-gray-200">
        <div class="px-4 py-3 space-y-1">
            <x-responsive-nav-link
                :href="route('admin.dashboard')"
                :active="request()->routeIs('admin.dashboard')">
                Dashboard
            </x-responsive-nav-link>

            <x-responsive-nav-link
                :href="route('admin.appointments.index')"
                :active="request()->routeIs('admin.appointments.*')">
                Medical Appointments
            </x-responsive-nav-link>
        </div>

        <div class="border-t border-gray-200 px-4 py-3">
            <div class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</div>
            <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>

            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <x-responsive-nav-link
                    :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    Log Out
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>
