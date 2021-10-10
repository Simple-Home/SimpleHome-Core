<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecordOriginCollum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sh_records', function (Blueprint $table) {
            $table->enum('origin', ['api', 'client', 'device', "automation", "web"])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sh_records', function (Blueprint $table) {
            $table->dropColumn('origin');
        });
    }
}
