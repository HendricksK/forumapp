<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        
        User::factory()
        ->count(50)
        ->create();
        // Looking to use factories in order to seed multiple of class.
        // https://laravel.com/docs/8.x/seeding
    }
}