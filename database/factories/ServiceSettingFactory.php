<?php

namespace Database\Factories;

use App\Models\ServiceSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceSettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ServiceSetting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $durations = ['0100', '0030', '0130', '0200'];

        $weekdays = ServiceSetting::getWeekdays();

        $dayFrom = $weekdays[rand(0,2)];
        $dayTo = $weekdays[rand(3, 5)];

        $startTime = rand(600,900);
        $endTime = rand(1200, 1900);

        return [
            'user_id' => 1,
            'name' => $this->faker->word(),
            'places' => rand(1, 10),
            //'day_fom' => $dayFrom,
            //'day_to' => $dayTo,
            'monday' => rand(0,1),
            'tuesday' => rand(0,1),
            'wednesday' => rand(0,1),
            'thursday' => rand(0,1),
            'friday' => rand(0,1),
            'saturday' => rand(0,1),
            'sunday' => rand(0,1),
            //'start_time' => '0'.$startTime,
            //'end_time' => $endTime,
            'duration' => $durations[rand(0, sizeof($durations)-1)],
            'price' => 40.00,
        ];
    }
}
