@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold mb-8">Edit Doctor: {{ $doctor->name }}</h1>

    <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.doctors.form')

        <div class="mt-6">
            <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">
                Update Doctor
            </button>
            <a href="{{ route('admin.doctors.index') }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
        </div>
    </form>
</div>
@endsection
