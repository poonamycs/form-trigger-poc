<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Batch extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'start_time', 'end_time',
    ];
}
