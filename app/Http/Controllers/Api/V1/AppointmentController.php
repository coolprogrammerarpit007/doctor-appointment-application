<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppointmentController extends Controller
{

    public function store(Request $request)
{
    DB::beginTransaction();

    try {
        // Validate request
        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:30',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|string',
            'time' => 'required|date_format:H:i',
            'reason' => 'nullable|string|max:1000',
        ]);

        $doctor = Doctor::findOrFail($validated['doctor_id']);

        $requestedDate = Carbon::parse($validated['date'])->format('Y-m-d');
        $requestedTime = $validated['time'];

        // Fetch available times
        $availability = $this->getAvailableTimes($doctor, $requestedDate);
        if (!in_array($requestedTime, $availability['available_times'])) {
            return response()->json([
                'success' => false,
                'message' => 'The selected time slot is not available.',
            ], 422);
        }

        // Create appointment
        $appointment = Appointment::create([
            'doctor_id' => $doctor->id,
            'patient_name' => $validated['full_name'],
            'patient_email' => $validated['email'],
            'patient_phone' => $validated['phone'],
            'appointment_date' => $requestedDate,
            'appointment_time' => $requestedTime . ':00',
            'reason' => $validated['reason'] ?? null,
            'status' => 'confirmed',
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Appointment booked successfully.',
            'data' => $appointment->load('doctor'),
        ], 201);

    } catch (\Throwable $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Failed to create appointment.',
            'error' => config('app.debug') ? $e->getMessage() : null,
        ], 500);
    }
}



    /**
     * Helper method to get available times (replicates logic from DoctorController)
     */

    private function getAvailableTimes(Doctor $doctor, string $date): array
{
    $requestedDate = Carbon::parse($date)->startOfDay();

    // mon, tue, wed...
    $dayKey = strtolower($requestedDate->format('D'));
    $rules = $doctor->availability_rules;

    if (
        empty($rules) ||
        empty($rules['days']) ||
        empty($rules['start']) ||
        empty($rules['end'])
        ) {
            return ['available_times' => []];
        }



    // Weekday map
        $weekMap = [
            'mon' => 1,
            'tue' => 2,
            'wed' => 3,
            'thu' => 4,
            'fri' => 5,
            'sat' => 6,
            'sun' => 7,
        ];



    // ❌ Doctor not available on this weekday
    if (!empty($rules['days'])) {
            // Example: Mon-Fri
            [$startDay, $endDay] = array_map('strtolower', explode('-', $rules['days']));

            if (
                !isset($weekMap[$startDay], $weekMap[$endDay], $weekMap[$dayKey]) ||
                $weekMap[$dayKey] < $weekMap[$startDay] ||
                $weekMap[$dayKey] > $weekMap[$endDay]
            ) {
                return ['available_times' => []];
            }
        }



        $slotDuration = (int) ($rules['slot_duration'] ?? 30);

        $startTime = Carbon::createFromFormat('H:i', $rules['start']);
        $endTime   = Carbon::createFromFormat('H:i', $rules['end']);

        $slots = [];
        $current = $startTime->copy();

        // Generate slots
        while ($current->lessThan($endTime)) {
            $slots[] = $current->format('H:i');
            $current->addMinutes((int)$slotDuration);
        }

        // Fetch already booked slots
        $bookedTimes = $doctor->appointments()
            ->whereDate('appointment_date', $requestedDate)
            ->pluck('appointment_time')
            ->map(fn ($time) => Carbon::parse($time)->format('H:i'))
            ->toArray();

        // Remove booked slots
        $availableTimes = array_values(array_diff($slots, $bookedTimes));

        /**
         * ⏳ Remove past slots if date is today
         */
        if ($requestedDate->isToday()) {
            $now = Carbon::now()->format('H:i');

            $availableTimes = array_values(
                array_filter($availableTimes, fn ($time) => $time > $now)
            );
        }

        return [
            'available_times' => $availableTimes,
        ];
}

}
