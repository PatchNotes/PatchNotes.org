<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use PatchNotes\Models\NotificationLevel;

class MigrationRenameQueueToKey extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('notification_levels', function(Blueprint $table) {
			$table->renameColumn('queue', 'key');
		});

		foreach(NotificationLevel::all() as $level) {
			$level->key = str_replace('pn_', '', $level->key);
			$level->save();
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('notification_levels', function(Blueprint $table) {
			$table->renameColumn('key', 'queue');
		});

		foreach(NotificationLevel::all() as $level) {
			$level->queue = "pn_" . $level->queue;
			$level->save();
		}
	}

}
