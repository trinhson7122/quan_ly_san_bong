<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FootballPitchLink extends Model
{
    use HasFactory;
    protected $fillable = [
        'from_football_pitch_id',
        'to_football_pitch_id',
    ];
}
