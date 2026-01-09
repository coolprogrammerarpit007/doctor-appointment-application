<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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
    // -----------------------------------------------------------------
    // 1. Validation – field names must be exactly the same as in the form
    // -----------------------------------------------------------------
    $validated = $request->validate([
        'doctor_name'                => 'required|string|max:100',
        'specialty'                  => 'required|string|max:100',
        'description'                => 'nullable|string',
        'experience_years'           => 'nullable|integer|min:0|max:50',

        // Availability rules – note the dot-notation
        'availability_rules.days'        => 'required|string',
        'availability_rules.start'       => 'required|date_format:H:i',
        'availability_rules.end'         => 'required|date_format:H:i|after:availability_rules.start',
        'availability_rules.slot_duration'=> 'required|integer|min:15|max:120',

        // Photo
        'photo'                      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',

        // User (login) fields
        'email'                      => 'required|email|unique:users,email',
        'password'                   => 'required|string|min:8|confirmed',
    ]);

    // -----------------------------------------------------------------
    // 2. Photo upload
    // -----------------------------------------------------------------
    $photoPath = null;
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('doctors', 'public');
    }

    // -----------------------------------------------------------------
    // 3. Create the USER (login account) + assign "doctor" role
    // -----------------------------------------------------------------
    $user = \App\Models\User::create([
        'name'     => $validated['doctor_name'],   // <-- use doctor_name here
        'email'    => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);
    $user->assignRole('doctor');

    // -----------------------------------------------------------------
    // 4. Create the DOCTOR record (link to the user)
    // -----------------------------------------------------------------
    Doctor::create([
        'doctor_name'      => $validated['doctor_name'],
        'specialty'        => $validated['specialty'],
        'description'      => $validated['description'],
        'experience_years' => $validated['experience_years'],
        'availability_rules' => [
            'days'          => $validated['availability_rules']['days'],
            'start'         => $validated['availability_rules']['start'],
            'end'           => $validated['availability_rules']['end'],
            'slot_duration' => $validated['availability_rules']['slot_duration'],
        ],
        'photo_path'       => $photoPath,
        'is_active'        => 1,               // or 1 if column is tinyint
        'user_id'          => $user->id,
    ]);

    // -----------------------------------------------------------------
    // 5. Redirect with success message
    // -----------------------------------------------------------------
    return redirect()
        ->route('admin.doctors.index')
        ->with('success', 'Doctor added successfully with login credentials.');
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
            // 'rating' => 'nullable|numeric|min:0|max:5',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'email' => 'required|email|unique:users,email,' . $doctor->user_id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $photoPath = $doctor->photo_path;
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $request->file('photo')->store('doctors', 'public');
        }

        // Update user
        $doctor->user->update([
            'name' => $validated['doctor_name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? bcrypt($validated['password']) : $doctor->user->password,
        ]);

        // Update doctor
        $doctor->update([
            'doctor_name' => $validated['doctor_name'],
            'specialty' => $validated['specialty'],
            'description' => $validated['description'],
            'experience_years' => $validated['experience_years'],
            'availability_rules' => [
                'days' => $validated['availability_rules']['days'],
                'start' => $validated['availability_rules']['start'],
                'end' => $validated['availability_rules']['end'],
                'slot_duration' => $validated['availability_rules']['slot_duration'],
            ],
            'photo_path' => $photoPath,
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
