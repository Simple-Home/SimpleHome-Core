<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShAutomations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sh_automations', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->boolean('is_enabled')->default(false);
            $table->bigInteger('owner_id')->unsigned();
            $table->json('conditions');
            $table->json('actions');
            $table->timestamp('run_at')->nullable();
            $table->timestamps();
        });
        
        Schema::table('sh_automations', function($table) {
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sh_automations');
    }
}
