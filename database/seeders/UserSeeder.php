<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('orchid:admin', [
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => 'secret123'
        ]);
    }
}
