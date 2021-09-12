<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

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

    public static function getWeekdays(): array
    {
        return self::WEEKDAYS;
    }

    public function times(): HasMany
    {
        return $this->hasMany(ServiceSettingsTimes::class, 'service_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'service_id');
    }

    /**
     * Get the available days for the service
     *
     * @return array The array of days
     */
    public function getServiceDaysAttribute(): array
    {

        $serviceDays = [];

        foreach (self::WEEKDAYS as $day) {
            if ($this->{$day}) {
                $serviceDays[] = $day;
            }
        }

        return $serviceDays;
    }

    /**
     * Get the time schedule for the service
     *
     * @return array An array with time schedule in military fromat
     */
    private function getSchedule(): array
    {
        $schedule = [];

        foreach ($this->times as $time) {
            $startTime = (int) $time->start_time;
            $serviceDuration = (int) $this->duration;

            while ($startTime <= (int) $time->end_time) {
                $strTime = formatStringTime($startTime);
                $hourKey = converStringTime($strTime);

                array_push($schedule, $hourKey);

                $startTime = (int) $hourKey + $serviceDuration;
            }
        }

        return $schedule;
    }

    /**
     * Get the schedules for each services
     *
     * @return void
     */
    public static function getAllSchedules(array $services, string $date): array
    {
        $schedules = [];

        foreach ($services as $service) {
            foreach ($service->times as $time) {

                $startTime = (int) $time->start_time;
                $serviceDuration = (int) $service->duration;

                while ($startTime <= (int) $time->end_time) {
                    $strTime = formatStringTime($startTime);

                    $hourKey = converStringTime($strTime);
                    $correctFormatedHour = formatStringTime((int) $hourKey);

                    $schedules[$hourKey] = [
                        'service' => $service,
                        'places' => $service->getRemainingPlaces($date . ' ' . $correctFormatedHour),
                    ];
                    $startTime = (int) $hourKey + $serviceDuration;
                }
            }
        }

        return $schedules;
    }

    /**
     * Verify if a service respect the period settings
     *
     * @param string $moment The date of the service
     * @return boolean
     */
    public function isMomentInPeriod(string $moment): bool
    {
        $selectedDate = Carbon::create($moment);

        $dayStr = strtolower($selectedDate->englishDayOfWeek);
        $time =  (int) ($selectedDate->format('G') . $selectedDate->format('i'));

        return
            in_array($time, $this->getSchedule())
            &&
            in_array($dayStr, $this->service_days);
    }

    /**
     * Get the number of remaining places for the service
     * at $moment
     *
     * @param string $moment The date of the service
     * @return integer The number of places
     */
    public function getRemainingPlaces(string $moment): int
    {
        $selectedDate = Carbon::create($moment);

        $bookedPlaces = $this
            ->bookings()
            ->where('moment', $selectedDate->format('Y-m-d G:i:s'))
            ->count();

        return $this->places - $bookedPlaces;
    }

    /**
     * Look if it still remaining places for the service
     *
     * @param string $moment The date of the service
     * @return boolean
     */
    public function isRemainingPlaces(string $moment): bool
    {
        return $this->getRemainingPlaces($moment) > 0;
    }

    /**
     * Get number of places for the given date
     *
     * @param string $date
     * @return integer
     */
    public function getPlacesForDay(string $date): int
    {
        return 0;
    }
}
