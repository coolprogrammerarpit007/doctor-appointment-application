<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with('doctor')
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(15);

        return view('admin.appointments.index', compact('appointments'));
    }


    public function cancel(Appointment $appointment)
    {
        $appointment->update(['status' => 'cancelled']);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment cancelled successfully.');
    }

    public function complete(Appointment $appointment)
    {
        $appointment->update(['status' => 'completed']);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment marked as completed.');
    }
}
