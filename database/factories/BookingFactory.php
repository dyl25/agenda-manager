<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\ServiceSetting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $currentService = ServiceSetting::find(rand(1, 3));
        $currentUser = User::factory()->create();

        return [
            'user_id' => $currentUser->id,
            'service_id' => $currentService->id,
            'moment' => $this->faker->date(),
            'email' => $currentUser->email,
            'mobile' => $this->faker->phoneNumber(),
            'name' => $currentUser->name,
            'firstname' => $currentUser->firstname,
            'comments' => implode('\n', $this->faker->sentences(3)),
        ];
    }
}
