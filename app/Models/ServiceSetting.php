<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'day_fom',
        'day_to',
        'start_time',
        'end_time',
        'duration',
        'price',
    ];
}
