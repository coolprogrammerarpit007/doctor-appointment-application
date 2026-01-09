<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::paginate(10);

        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_name' => 'required|string|max:100',
            'specialty' => 'required|string|max:100',
            'description' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'availability_rules.days' => 'required|string',
            'availability_rules.start' => 'required|date_format:H:i',
            'availability_rules.end' => 'required|date_format:H:i|after:availability_rules.start',
            'availability_rules.slot_duration' => 'required|integer|min:15|max:120',
            'photo_url' => 'nullable|url',
        ]);

        // Convert availability_rules to JSON array
        $availability = [
            'days' => $validated['availability_rules']['days'],
            'start' => $validated['availability_rules']['start'],
            'end' => $validated['availability_rules']['end'],
            'slot_duration' => $validated['availability_rules']['slot_duration'],
        ];

        Doctor::create([
            'doctor_name' => $validated['doctor_name'],
            'specialty' => $validated['specialty'],
            'description' => $validated['description'],
            'experience_years' => $validated['experience_years'],
            'availability_rules' => $availability,
            'photo_url' => $validated['photo_url'] ?? null,
            'is_active' => 1,
        ]);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Doctor added successfully.');
    }

    public function edit(Doctor $doctor)
    {
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'doctor_name' => 'required|string|max:100',
            'specialty' => 'required|string|max:100',
            'description' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'availability_rules.days' => 'required|string',
            'availability_rules.start' => 'required|date_format:H:i',
            'availability_rules.end' => 'required|date_format:H:i|after:availability_rules.start',
            'availability_rules.slot_duration' => 'required|integer|min:15|max:120',
            'rating' => 'nullable|numeric|min:0|max:5',
            'photo_url' => 'nullable|url',
        ]);

        $availability = [
            'days' => $validated['availability_rules']['days'],
            'start' => $validated['availability_rules']['start'],
            'end' => $validated['availability_rules']['end'],
            'slot_duration' => $validated['availability_rules']['slot_duration'],
        ];

        $doctor->update([
            'doctor_name' => $validated['doctor_name'],
            'specialty' => $validated['specialty'],
            'description' => $validated['description'],
            'experience_years' => $validated['experience_years'],
            'availability_rules' => $availability,
            'rating' => $validated['rating'] ?? $doctor->rating,
            'photo_url' => $validated['photo_url'],
        ]);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Doctor updated successfully.');
    }

    public function destroy(Doctor $doctor)
    {
        // Toggle active status instead of deleting
        $doctor->update(['is_active' => !$doctor->is_active]);

        $status = $doctor->is_active ? 'activated' : 'deactivated';

        return redirect()->route('admin.doctors.index')
            ->with('success', "Doctor {$status} successfully.");
    }
}
