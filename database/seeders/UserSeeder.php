<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ab_user;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ab_user::factory()->count(10)->create();
    }
}
// Path: database/seeders/UserSeeder.php
