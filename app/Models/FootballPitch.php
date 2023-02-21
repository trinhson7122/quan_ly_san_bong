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
        'pitch_type_id',
        'from_football_pitch_id',
        'to_football_pitch_id',
    ];

    public function pitchType()
    {
        return $this->belongsTo(PitchType::class, 'pitch_type_id');
    }

    public function fromFootballPitch()
    {
        return $this->belongsTo(FootballPitch::class, 'from_football_pitch_id');
    }

    public function toFootballPitch()
    {
        return $this->belongsTo(FootballPitch::class, 'to_football_pitch_id');
    }
}
