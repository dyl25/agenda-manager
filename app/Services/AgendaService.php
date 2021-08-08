<?php

namespace App\Services;

use App\Models\ServiceSetting;
use Illuminate\Support\Carbon;
use App;

class AgendaService
{

    public function getAgenda(int $user_id = null, int $year = null, int $month = null, int $day = 1): array
    {
        $currentDate = null;

//dd(Carbon::now()->isoFormat('dddd D'));
        //dd(Carbon::getLocale());
        //dd(\ResourceBundle::getLocales(''));

        if ($day && $month && $year) {
            $currentDate = Carbon::create($year . '-' . $month . '-' . $day)->setLocale('fr');
        } else {
            $currentDate = Carbon::now();
        }

        $addedDate = clone ($currentDate);
        $nextMonth = clone ($currentDate)->endOfMonth()->add(1, 'day');

        $servicesQuery = ServiceSetting::with('times');

        if ($user_id) {
            $servicesQuery->where('user_id', $user_id);
        }

        $services = $servicesQuery->get();

        $remainingDates = [];

        while ($addedDate->month !== $nextMonth->month) {

            $cpt = 0;
            $servicesArr = [];

            while ($cpt < sizeof($services)) {
                if (in_array(
                    lcfirst($addedDate->format('l')),
                    $services[$cpt]->service_days
                )) {
                    array_push($servicesArr, $services[$cpt]);
                }

                $cpt++;
            }

            if (sizeof($servicesArr) > 0) {
                array_push($remainingDates, [
                    'dateFormat' => [
                        'date' => $addedDate->isoFormat('YYYY-MM-DD'),
                        'day' => $addedDate->isoFormat('dddd D'),
                        'completeDate' => $addedDate->isoFormat('dddd D MMMM YYYY')
                    ],
                    'hours' => ServiceSetting::getAllSchedules($servicesArr)
                ]);
            }

            $addedDate->add(1, 'day');
        }

        return $remainingDates;
    }
}
