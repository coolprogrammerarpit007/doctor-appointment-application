<div class="space-y-6">
    <div>
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <input type="text" name="doctor_name" value="{{ old('name', $doctor->doctor_name ?? '') }}" required
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Specialty</label>
        <input type="text" name="specialty" value="{{ old('specialty', $doctor->specialty ?? '') }}" required
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" rows="4"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $doctor->description ?? '') }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Experience (years)</label>
        <input type="number" name="experience_years" value="{{ old('experience_years', $doctor->experience_years ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Working Days (e.g., Mon-Fri)</label>
        <input type="text" name="availability_rules[days]" value="{{ old('availability_rules.days', $doctor->availability_rules['days'] ?? '') }}" required
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

    <div>
        <label class="block text-sm font-medium text-gray-700">Slot Duration (minutes)</label>
        <input type="number" name="availability_rules[slot_duration]" value="{{ old('availability_rules.slot_duration', $doctor->availability_rules['slot_duration'] ?? 30) }}" required
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    </div>

    {{-- <div>
        <label class="block text-sm font-medium text-gray-700">Rating (0-5)</label>
        <input type="number" step="0.1" name="rating" value="{{ old('rating', $doctor->rating ?? 4.9) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    </div> --}}

    <div>
        <label class="block text-sm font-medium text-gray-700">Photo URL (optional)</label>
        <input type="url" name="photo_url" value="{{ old('photo_url', $doctor->photo_url ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    </div>
</div>
