<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;


    /** *


    * The attributes that are mass-assignable

    */


    protected $fillable = [
        'doctor_name',
        'specialty',
        'description',
        'experience_years',
        'availability_rules',
        'photo_url',
        'is_active'
    ];


    // Cast attributes to the native types
    protected $casts = [
        'availability_rules' => 'array' // => 'automatically converts json to array
    ];


    // relationships

    public function appointments()
    {
        return $this->hasMany(Appointment::class,'doctor_id','id');
    }
}
