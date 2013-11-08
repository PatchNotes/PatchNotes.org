<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PnAddServices extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('projects', function(Blueprint $table) {
            $table->increments('id');

            $table->string('name', 200);
            $table->string('slug', 255)->unique();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('site_url')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });

        Schema::create('project_managers', function(Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('project_id')->unsigned();

            $table->unique(array('user_id', 'project_id'));

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('projects');
        Schema::drop('project_managers');
    }
}
