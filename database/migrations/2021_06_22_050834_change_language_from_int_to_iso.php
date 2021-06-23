<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeLanguageFromIntToIso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // change to ISO 639-1
        Schema::table('users', function (Blueprint $table) {
            $table->string('language',5)->change()->default('en');
        });

        DB::table('users')
            ->where('language', 1)
            ->update(["language" => 'en']);

        DB::table('users')
            ->where('language', 2)
            ->update(["language" => 'cs']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('language')->change()->default(1);
        });

        DB::table('users')
            ->where('language', 'en')
            ->update(["language" => 1]);

        DB::table('users')
            ->where('language', 'cs')
            ->update(["language" => 2]);
    }
}
