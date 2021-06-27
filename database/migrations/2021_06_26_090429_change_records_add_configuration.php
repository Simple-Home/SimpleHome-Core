<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeRecordsAddConfiguration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // change to ISO 639-1
        Schema::table('records', function (Blueprint $table) {
            $table->json('value')->change();
        });

        Schema::create('configurations', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('configuration_key')->unique()->index();
            $table->longText('configuration_value');
            $table->timestamps();
        });

        DB::table('configurations')->insert(
            [
                [
                    'configuration_key' => 'simplehome.housekeeping.interval',
                    'configuration_value' => '432000'
                ],
                [
                    'configuration_key' => 'simplehome.housekeeping.active',
                    'configuration_value' => true
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
        Schema::table('records', function (Blueprint $table) {
            $table->string('value')->change();
        });

        Schema::drop('configurations');
    }
}
