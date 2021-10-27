<?php

namespace Database\Seeders;

use App\Models\Devices;
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
        Devices::factory(10)->create();
    }
}
