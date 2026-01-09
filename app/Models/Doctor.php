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

    protected $appends = ['photo_url'];
    public function getPhotoUrlAttribute()
{
    return $this->photo_path ? asset('storage/' . $this->photo_path) : asset('images/default-doctor.jpg');
}


    protected $fillable = [
        'doctor_name',
        'specialty',
        'description',
        'experience_years',
        'availability_rules',
        'photo_path',
        'is_active',
        'user_id'
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


    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
