<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReanmeAllShTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('devices', 'sh_devices');
        Schema::rename('properties', 'sh_properties');
        Schema::rename('records', 'sh_records');
        Schema::rename('rooms', 'sh_rooms');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('sh_devices', 'devices');
        Schema::rename('sh_properties', 'properties');
        Schema::rename('sh_records', 'records');
        Schema::rename('sh_rooms', 'rooms');
    }
}
