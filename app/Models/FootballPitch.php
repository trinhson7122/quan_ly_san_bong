<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FootballPitch extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'time_start',
        'time_end',
        'description',
        'price_per_hour',
        'price_per_peak_hour',
        'is_maintenance',
        'football_pitch_link_id',
        'pitch_type_id',
    ];
}
