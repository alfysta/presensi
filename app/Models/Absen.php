<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','date_absensi','time_in','time_out','photo_in','photo_out','location_in','location_out'];
}
