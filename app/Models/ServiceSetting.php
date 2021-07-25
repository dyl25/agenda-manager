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

    protected $appends = [
        'service_days'
    ];

    public static function getWeekdays() {
        return self::WEEKDAYS;
    }

    public function times() {
        return $this->hasMany(ServiceSettingsTimes::class, 'service_id');
    }

    public function getServiceDaysAttribute() {

        $serviceDays = [];

        foreach (self::WEEKDAYS as $day) {
            if($this->{$day}) {
                $serviceDays[] = $day;
            }
        }

        return $serviceDays;
    }
}
