<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSetting extends Model
{
    use HasFactory;

    const WEEKDAYS = [
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
    ];

    protected $fillable = [
        'user_id',
        'name',
        'day_fom',
        'day_to',
        'start_time',
        'end_time',
        'duration',
        'price',
    ];

    public static function getWeekdays() {
        return self::WEEKDAYS;
    }
}
