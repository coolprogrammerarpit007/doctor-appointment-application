<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hospital Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h1 class="text-3xl font-bold mb-8">Hospital Dashboard</h1>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-blue-100 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold">Total Doctors</h3>
                            <p class="text-3xl font-bold text-blue-600">{{ $doctorsCount }}</p>
                        </div>
                        <div class="bg-green-100 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold">Total Appointments</h3>
                            <p class="text-3xl font-bold text-green-600">{{ $appointmentsCount }}</p>
                        </div>
                        <div class="bg-purple-100 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold">Today's Appointments</h3>
                            <p class="text-3xl font-bold text-purple-600">{{ $todayAppointments }}</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h2 class="text-2xl font-bold mb-4">Welcome, Admin!</h2>
                        <p>Use the navigation to manage doctors and appointments.</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
