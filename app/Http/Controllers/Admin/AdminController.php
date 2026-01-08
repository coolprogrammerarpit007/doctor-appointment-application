<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $doctorsCount = Doctor::count();
        $appointmentsCount = Appointment::count();
        $todayAppointments = Appointment::whereDate('appointment_date', today())->count();

        return view('admin.dashboard', [
    'doctorsCount' => $doctorsCount,
    'appointmentsCount' => $appointmentsCount,
    'todayAppointments' => $todayAppointments,
]);
    }
}
