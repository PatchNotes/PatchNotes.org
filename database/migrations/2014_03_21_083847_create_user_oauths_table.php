<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateUserOauthsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_oauths', function ($table)
        {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('provider');
            $table->integer('provider_user_id');
            $table->text('provider_user_details');
            $table->string('validation_key');
            $table->boolean('validated')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Associated user_oauths.user_id with users.id as an oauth user must
            // belong to a user
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
        Schema::drop('user_oauths');
    }

}
