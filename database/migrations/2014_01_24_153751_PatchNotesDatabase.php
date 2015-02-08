<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PatchNotes\Models\NotificationLevel;
use PatchNotes\Models\ProjectUpdateLevel;

class PatchNotesDatabase extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('organizations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->string('name');
            $table->string('slug');
            $table->string('site_url');
            $table->string('email');
            $table->mediumText('description');
            $table->timestamps();

            $table->unique('name');
        });
        Schema::create('organization_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integer('user_id')->unsigned();
            $table->integer('organization_id')->unsigned();
            $table->boolean('creator');

            $table->primary(array('user_id', 'organization_id'));

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('organization_id')->references('id')->on('organizations');
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->string('name', 200);
            $table->string('slug', 255)->unique();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('site_url')->nullable();

            $table->integer('owner_id')->unsigned();
            $table->string('owner_type');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('project_updates_levels', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->integer('level')->unsigned()->unique();
            $table->string('name');

            $table->timestamps();
        });

        $levels = array(
            10 => "Newsletter",
            50 => "Product Updates",
            100 => "Service Changes"
        );
        foreach ($levels as $level => $name) {
            ProjectUpdateLevel::create(compact('level', 'name'));
        }

        Schema::create('project_updates', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->integer('project_id')->unsigned();
            $table->string('title');
            $table->string('slug');
            $table->text('body');
            $table->integer('level')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(array('project_id', 'slug'));

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('level')->references('level')->on('project_updates_levels');
        });

        Schema::create('notification_levels', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->integer('level')->unsigned()->unique();
            $table->string('name');
            $table->string('queue')->unique();

            $table->timestamps();
        });

        $levels = array(
            array(
                'level' => 0,
                'name' => 'Immediate',
                'queue' => 'pn_immediate'
            ),
            array(
                'level' => 24,
                'name' => 'Daily Digest',
                'queue' => 'pn_daily'
            ),
            array(
                'level' => 168,
                'name' => 'Weekly Digest',
                'queue' => 'pn_weekly'
            )
        );
        foreach ($levels as $level) {
            NotificationLevel::create($level);
        }

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->integer('project_id')->unsigned()->nullable();
            $table->integer('project_update_level')->unsigned();
            $table->integer('notification_level')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('project_update_level')->references('level')->on('project_updates_levels');
            $table->foreign('notification_level')->references('level')->on('notification_levels');

            $table->timestamps();

            $table->unique(array('project_id', 'user_id', 'project_update_level'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
