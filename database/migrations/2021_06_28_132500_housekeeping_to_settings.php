<?php

use App\Models\Settings;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HousekeepingToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::dropIfExists('configurations');


        DB::table('settings')->insert(
            [
                [
                    'name' => 'interval',
                    'group' => 'housekeeping',
                    'type' => 'int',
                    'value' => '432000',
                    'created_at' => now()
                ],
                [
                    'name' => 'active',
                    'group' => 'housekeeping',
                    'type' => 'boolean',
                    'value' => true,
                    'created_at' => now()
                ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Settings::where(['name' => 'active', 'group' => 'housekeeping'])->delete();
        Settings::where(['name' => 'interval', 'group' => 'housekeeping'])->delete();
    }
}
