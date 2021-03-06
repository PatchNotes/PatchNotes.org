<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use PatchNotes\Models\ProjectUpdate;
use PatchNotes\Models\ProjectUpdateLevel;

class ReindexProjectUpdateLevel extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('project_updates', function(Blueprint $table) {
			$table->integer('project_update_level_id')->after('level')->unsigned()->nullable();

			$table->foreign('project_update_level_id')->references('id')->on('project_updates_levels');
		});

		$projectUpdates = ProjectUpdate::all();
		foreach($projectUpdates as $projectUpdate) {
			$projectUpdateLevel = ProjectUpdateLevel::where('level', $projectUpdate->level)->firstOrFail();

			$projectUpdate->project_update_level_id = $projectUpdateLevel->id;
		}

		Schema::table('project_updates', function(Blueprint $table) {
			$table->dropForeign('project_updates_level_foreign');
			$table->dropColumn('level');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		return "Still no way back.";
	}

}
