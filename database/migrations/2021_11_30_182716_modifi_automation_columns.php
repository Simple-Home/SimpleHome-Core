<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifiAutomationColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sh_automations', function (Blueprint $table) {
            $table->boolean('is_locked')->default(False);
            $table->boolean('is_runed')->default(False);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sh_automations', function (Blueprint $table) {
            $table->dropColumn('is_locked');
            $table->dropColumn('is_runed');
        });
    }
}
