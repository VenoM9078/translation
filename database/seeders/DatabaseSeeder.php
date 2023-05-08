<?php

namespace Database\Seeders;

use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        //insert a new admin without using factory class
        \App\Models\Admin::create([
            'name' => 'Test Admin',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}