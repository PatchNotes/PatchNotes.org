<?php

use Illuminate\Database\Migrations\Migration;

class MigrationCartalystSentrySocialAddAccessTokenSecret extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('social', function($table)
		{
			$table->string('access_token_secret')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('social', function($table)
		{
			$table->dropColumn('access_token_secret');
		});
	}

}
