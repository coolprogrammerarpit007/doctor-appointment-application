@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <h1 class="text-3xl font-bold mb-8">Edit Doctor: {{ $doctor->name }}</h1>

    <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.doctors.form')

        <div class="mt-8 flex gap-4">
            <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition">
                Update Doctor
            </button>
            <a href="{{ route('admin.doctors.index') }}" class="px-8 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
