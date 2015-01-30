<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationAddUserSendTimes extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_preferences', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();

            $table->string('timezone')->default('UTC');
            $table->time('daily_time')->default('8:00');
            $table->string('weekly_day')->default('Sunday');
            $table->time('weekly_time')->default('8:00');

            $table->timestamps();

            $table->unique('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_preferences');
    }

}
