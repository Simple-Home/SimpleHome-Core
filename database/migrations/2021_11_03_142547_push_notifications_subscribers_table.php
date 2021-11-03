<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PushNotificationsSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sh_push_notifications_subscribers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('recipient_id')->unsigned();
            $table->string("token")->unique();
            $table->string("provider")->default('firebase');
            $table->timestamps();
        });

        Schema::table('sh_push_notifications_subscribers', function($table) {
            $table->foreign('recipient_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sh_push_notifications_subscribers');
    }
}
