<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddUserProjectUpdates extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_project_updates', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->integer('project_id')->unsigned();
            $table->integer('project_update_id')->unsigned();

            $table->integer('project_update_level_id')->unsigned();
            $table->integer('notification_level_id')->unsigned();

            $table->timestamp('emailed_at')->nullable();
            $table->timestamp('seen_at')->nullable();

            $table->timestamps();

            $table->unique(array('user_id', 'project_id', 'project_update_id'));

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('project_update_id')->references('id')->on('project_updates');
            $table->foreign('project_update_level_id')->references('id')->on('project_updates_levels');
            $table->foreign('notification_level_id')->references('id')->on('notification_levels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_project_updates');
    }

}
