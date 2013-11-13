<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PnAddUpdates extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('project_updates', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('project_id')->unsigned();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('body');
            $table->integer('subscription_level')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('subscription_level')->references('level')->on('subscription_levels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('project_updates');
    }
}
