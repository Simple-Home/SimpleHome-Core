<?php

namespace Database\Seeders;

use App\Models\Records;
use Illuminate\Database\Seeder;

class RecordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Records::factory(1000)->create();
    }
}
