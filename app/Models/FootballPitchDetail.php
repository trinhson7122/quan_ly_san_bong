<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FootballPitchDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'football_pitch_id',
    ];
}
