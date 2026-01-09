@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Manage Doctors</h1>
        <a href="{{ route('admin.doctors.create') }}" class="bg-teal-600 text-white px-6 py-3 rounded-lg hover:bg-teal-700 transition">
            Add New Doctor
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Specialty</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Experience</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($doctors as $doctor)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($doctor->photo_path)
                            <img src="{{ $doctor->photo_url }}" alt="{{ $doctor->doctor_name }}" class="h-16 w-16 rounded-full object-cover shadow">
                        @else
                            <div class="h-16 w-16 rounded-full bg-gray-200 border-2 border-dashed flex items-center justify-center">
                                <span class="text-gray-400 text-xs">No photo</span>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $doctor->name }}</div>
                        <div class="text-sm text-gray-500">{{ $doctor->user->email ?? '—' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $doctor->specialty }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $doctor->experience_years ? $doctor->experience_years . ' years' : '—' }}
                    </td>
                    {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $doctor->rating }}</td> --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $doctor->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $doctor->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-4">
                        <a href="{{ route('admin.doctors.edit', $doctor) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900"
                                    onclick="return confirm('Toggle active status for {{ $doctor->name }}?')">
                                {{ $doctor->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">No doctors found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-6 py-4 bg-gray-50">
            {{ $doctors->links() }}
        </div>
    </div>
</div>
@endsection
