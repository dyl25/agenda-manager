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
        'name',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
        'duration',
        'price',
        'places'
    ];

    public static function getWeekdays() {
        return self::WEEKDAYS;
    }

    public function times() {
        return $this->hasMany(ServiceSettingsTimes::class);
    }
}
