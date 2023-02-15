<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'email',
        'deposit',
        'code',
        'start_at',
        'end_at',
        'total',
        'status',
        'note',
        'user_id',
        'football_pitch_id',
    ];
}
