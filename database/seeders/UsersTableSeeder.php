<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        DB::table('users')->insert([
            'role_id' => 2,
            "name" => "Vansteenacker",
            'firstname' => "Dylan",
            "email" => "dylan-vst@hotmail.com",
            "password" => app('hash')->make("epfc12"),
            "created_at" => new \DateTime(),
        ]);

        //User::factory()->count(50)->create();
    }
}
