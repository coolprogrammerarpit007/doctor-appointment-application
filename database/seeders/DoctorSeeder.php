<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Doctor;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Doctor::create([
            'doctor_name' => 'Dr. Sarah Mitchell',
            'specialty' => 'Cardiologist',
            'description' => 'Specialized in heart disease prevention and treatment with a focus on advanced cardiac care.',
            'experience_years' => 15,
            'availability_rules' => [
                'days' => 'Mon-Fri',
                'start' => '09:00',
                'end' => '17:00',
                'slot_duration' => 30,
            ],
            'photo_url' => null,
            'is_active' => 1,
        ]);

        Doctor::create([
            'doctor_name' => 'Dr. James Cooper',
            'specialty' => 'Pediatrician',
            'description' => 'Dedicated to providing comprehensive care for children from infancy through adolescence.',
            'experience_years' => 12,
            'availability_rules' => [
                'days' => 'Mon-Sat',
                'start' => '08:00',
                'end' => '16:00',
                'slot_duration' => 30,
            ],
            'photo_url' => null,
            'is_active' => 1,
        ]);

        Doctor::create([
            'doctor_name' => 'Dr. Emily Chen',
            'specialty' => 'Dermatologist',
            'description' => 'Expert in skin conditions, cosmetic procedures, and skin cancer detection and treatment.',
            'experience_years' => 10,
            'availability_rules' => [
                'days' => 'Tue-Sat',
                'start' => '10:00',
                'end' => '18:00',
                'slot_duration' => 30,
            ],
            'photo_url' => null,
            'is_active' => 1,
        ]);

        Doctor::create([
            'doctor_name' => 'Dr. Michael Brown',
            'specialty' => 'Orthopedic Surgeon',
            'description' => 'Specializes in treating musculoskeletal injuries and complex joint replacements.',
            'experience_years' => 18,
            'availability_rules' => [
                'days' => 'Mon-Thu',
                'start' => '08:00',
                'end' => '15:00',
                'slot_duration' => 30,
            ],
            'photo_url' => null,
            'is_active' => 1,
        ]);
    }
}
