<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifiPropertyesTableAddHiddenAndDisabled extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sh_properties', function (Blueprint $table) {
            $table->boolean('is_disabled')->default(False);
            $table->boolean('is_hidden')->default(False);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sh_properties', function (Blueprint $table) {
            $table->dropColumn('is_disabled');
            $table->dropColumn('is_hidden');
        });
    }
}
