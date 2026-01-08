<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('restrict');
            $table->string('patient_name',100);
            $table->string('patient_email',150);
            $table->string('patient_phone',30);
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->text('reason')->nullable();
            $table->enum('status',['pending','confirmed','cancelled','completed'])->default('confirmed');
            $table->text('notes')->nullable();
            $table->timestamps();
            // This prevents double booking for the same doctor on the same date & time
            $table->unique(['doctor_id', 'appointment_date', 'appointment_time'], 'unique_slot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
