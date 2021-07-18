<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();

        DB::table('roles')->insert([
            'name' => 'user',
            'display_name' => 'Athlète'
        ]);

        DB::table('roles')->insert([
            'name' => 'admin',
            'display_name' => 'Coach'
        ]);

        DB::table('roles')->insert([
            'name' => 'admin',
            'display_name' => 'Kiné'
        ]);
    }
}
