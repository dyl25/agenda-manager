<?php

namespace Database\Seeders;

use App\Models\ServiceSetting;
use Illuminate\Database\Seeder;

class ServiceSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceSetting::factory()->count(3)->create();
    }
}
