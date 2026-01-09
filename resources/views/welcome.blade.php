<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Wellness Medical') }} - Expert Medical Care</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @endif
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen flex flex-col">
    <!-- Header / Navigation -->
    <header class="w-full max-w-7xl mx-auto px-6 py-8">
        @if (Route::has('login'))
            <nav class="flex justify-end gap-6 text-sm">
                @auth
                    <a href="{{ url('/admin/dashboard') }}"
                       class="px-5 py-2 border border-[#19140035] dark:border-[#3E3E3A] hover:border-[#1915014a] dark:hover:border-[#62605b] rounded-sm font-medium">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-5 py-2 border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm font-medium">
                        Log in
                    </a>
                    {{-- @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-5 py-2 border border-[#19140035] dark:border-[#3E3E3A] hover:border-[#1915014a] dark:hover:border-[#62605b] rounded-sm font-medium">
                            Register
                        </a>
                    @endif --}}
                @endauth
            </nav>
        @endif
    </header>

    <!-- Main Hero Section -->
    <main class="flex-1 flex items-center justify-center px-6">
        <div class="max-w-4xl w-full text-center">
            <h1 class="text-5xl lg:text-6xl font-bold mb-6">
                Expert Medical Care<br>
                <span class="text-teal-600 dark:text-teal-400">When You Need It</span>
            </h1>

            <p class="text-xl lg:text-2xl text-[#706f6c] dark:text-[#A1A09A] mb-10 max-w-3xl mx-auto">
                Experience world-class healthcare with our team of dedicated professionals.<br>
                Book your appointment today and take the first step toward better health.
            </p>

            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                <a href="{{ route('admin.dashboard') }}"
                   class="bg-teal-600 hover:bg-teal-700 text-white font-semibold px-8 py-4 rounded-lg text-lg transition shadow-lg">
                    Book Appointment →
                </a>

                {{-- <a href="#"
                   class="border border-[#19140035] dark:border-[#3E3E3A] hover:border-[#1915014a] dark:hover:border-[#62605b] px-8 py-4 rounded-lg font-medium text-lg transition">
                    Learn More
                </a> --}}
            </div>

            <!-- Trust Indicators -->
            <div class="mt-16 grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold text-teal-600 dark:text-teal-400">24/7</div>
                    <div class="text-[#706f6c] dark:text-[#A1A09A]">Available</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-teal-600 dark:text-teal-400">100%</div>
                    <div class="text-[#706f6c] dark:text-[#A1A09A]">Secure</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-teal-600 dark:text-teal-400">Fast</div>
                    <div class="text-[#706f6c] dark:text-[#A1A09A]">Response</div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-8 text-center text-sm text-[#706f6c] dark:text-[#A1A09A]">
        <p>&copy; {{ date('Y') }} Wellness Medical Center. All rights reserved.</p>
    </footer>
</body>
</html>
