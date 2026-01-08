<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try
        {
            $query = Doctor::where('is_active',1);
            // Check if the 'specialty' parameter exists in the request
            if($request->filled('specialty'))
            {
                $search_term = $request->specialty;
                $query->where('specialty','like','%' . $search_term . '%');
            }

            $doctors = $query->orderBy('experience_years','desc')->get(['doctor_name','specialty','experience_years','availability_rules','photo_url']);

            return response()->json([
                'status'=>true,
                'message' => 'All doctors fetched successfully',
                'data' => $doctors
            ],200);
        }

        catch(\Exception $e)
        {

            return response()->json([
                'status' => false,
                'message' => 'try again later' . " " . $e->getMessage(),
            ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        try
        {
            return response()->json([
                'status' => true,
                'message' => 'doctor data fetched successfully!',
                'data' => $doctor
            ]);
        }


        catch(\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'some error occur on fetching doctor details'
            ],500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function availability(Request $request, $id)
{
    try {
        $doctor = Doctor::findOrFail($id);

        $validated = Validator::make($request->all(), [
            'date' => 'required|string'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validated->errors()
            ]);
        }


        $requested_date = Carbon::parse($request->date);
        $requestedDay = strtolower($requested_date->format('D'));

        $rules = $doctor->availability_rules;
        // dd($rules);
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


        if (!empty($rules['days'])) {
            // Example: Mon-Fri
            [$startDay, $endDay] = array_map('strtolower', explode('-', $rules['days']));

            if (
                !isset($weekMap[$startDay], $weekMap[$endDay], $weekMap[$requestedDay]) ||
                $weekMap[$requestedDay] < $weekMap[$startDay] ||
                $weekMap[$requestedDay] > $weekMap[$endDay]
            ) {
                return response()->json([
                    'success' => true,
                    'doctor_id' => $doctor->id,
                    'date' => $request->date,
                    'available_times' => []
                ]);
            }
        }


        $start = Carbon::createFromFormat('H:i', $rules['start']);
        $end = Carbon::createFromFormat('H:i', $rules['end']);
        $slotDuration = $rules['slot_duration'] ?? 30;

        $slots = [];
        $current = $start->copy();

        while ($current->lessThan($end)) {
            $slots[] = $current->format('H:i');
            $current->addMinutes($slotDuration);
        }





       $bookedTimes = $doctor->appointments()
    ->where('appointment_date', $request->date)
    ->pluck('appointment_time')
    ->map(function ($time) {
        return $time->format('H:i');
    })
    ->toArray();


        $availableTimes = array_values(array_diff($slots, $bookedTimes));

        return response()->json([
            'success' => true,
            'doctor_id' => $doctor->id,
            'date' => $request->date,
            'available_times' => $availableTimes
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

}
