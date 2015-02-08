<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use PatchNotes\Models\User;

class MigrationCombineNames extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table) {
			$table->string('fullname')->nullable();
		});

		foreach(User::all() as $user) {
			$user->fullname = $user->first_name . " " . $user->last_name;
			$user->save();
		}

		Schema::table('users', function(Blueprint $table) {
			$table->dropColumn('first_name');
			$table->dropColumn('last_name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
