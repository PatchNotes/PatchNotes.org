<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use PatchNotes\Models\User;

class MigrationAddUnsubscribeFlagAndToken extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('unsubscribe_feedback', function(Blueprint $table) {
			$table->increments('id');

			$table->integer('user_id')->unsigned();
			$table->text('feedback');

			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users');
		});

		Schema::table('users', function(Blueprint $table) {
			$table->string('unsubscribe_token')->unique()->nullable();
			$table->timestamp('unsubscribed_at')->nullable()->default(null);
		});

		foreach(User::all() as $user) {
			$user->unsubscribe_token = str_random(42);
			$user->save();
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('unsubscribe_feedback');

		Schema::table('users', function(Blueprint $table) {
			$table->dropColumn(['unsubscribe_token','unsubscribed_at']);
		});
	}

}
