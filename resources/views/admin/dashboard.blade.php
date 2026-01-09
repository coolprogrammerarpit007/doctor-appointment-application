@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Hospital Admin Board</h1>

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

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Welcome, Hospital Admin</h2>
        <p>Use the menu to manage doctors and appointments.</p>
    </div>
</div>
@endsection
