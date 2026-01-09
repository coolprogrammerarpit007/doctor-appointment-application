<div class="space-y-8">
    <!-- Photo Upload -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Doctor Photo</label>
        <input type="file" name="photo" accept="image/*"
               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">

        @if(isset($doctor) && $doctor->photo_path)
            <div class="mt-4">
                <p class="text-sm text-gray-600 mb-2">Current Photo:</p>
                <img src="{{ $doctor->photo_url }}" alt="{{ $doctor->doctor_name }}" class="h-40 w-40 object-cover rounded-lg shadow-lg">
            </div>
        @endif
    </div>

    <!-- Name & Specialty -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="doctor_name" value="{{ old('doctor_name', $doctor->doctor_name ?? '') }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Specialty</label>
            <input type="text" name="specialty" value="{{ old('specialty', $doctor->specialty ?? '') }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
        </div>
    </div>

    <!-- Email & Password -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Email (for login)</label>
            <input type="email" name="email" value="{{ old('email', $doctor->user->email ?? '') }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">
                Password {{ isset($doctor) ? '(leave blank to keep current)' : '' }}
            </label>
            <input type="password" name="password" {{ isset($doctor) ? '' : 'required' }} minlength="8"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
            <input type="password" name="password_confirmation" {{ isset($doctor) ? '' : 'required' }}
                   class="mt-2 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
    </div>

    <!-- Description -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" rows="4"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">{{ old('description', $doctor->description ?? '') }}</textarea>
    </div>

    <!-- Experience & Rating -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Experience (years)</label>
            <input type="number" name="experience_years" value="{{ old('experience_years', $doctor->experience_years ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
        {{-- <div>
            <label class="block text-sm font-medium text-gray-700">Rating (0–5)</label>
            <input type="number" step="0.1" name="rating" value="{{ old('rating', $doctor->rating ?? 4.9) }}" min="0" max="5"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div> --}}
    </div>

    <!-- Availability Rules -->
    <div class="border-t pt-6">
        <h3 class="text-lg font-semibold mb-4">Availability Schedule</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Working Days (e.g., Mon-Fri)</label>
                <input type="text" name="availability_rules[days]" value="{{ old('availability_rules.days', $doctor->availability_rules['days'] ?? '') }}" required placeholder="Mon-Fri"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Start Time</label>
                    <input type="time" name="availability_rules[start]" value="{{ old('availability_rules.start', $doctor->availability_rules['start'] ?? '') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">End Time</label>
                    <input type="time" name="availability_rules[end]" value="{{ old('availability_rules.end', $doctor->availability_rules['end'] ?? '') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700">Slot Duration (minutes)</label>
            <input type="number" name="availability_rules[slot_duration]" value="{{ old('availability_rules.slot_duration', $doctor->availability_rules['slot_duration'] ?? 30) }}" required min="15" max="120"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
    </div>
</div>
