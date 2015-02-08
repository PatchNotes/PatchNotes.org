<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationLaravel5Updates extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach(\PatchNotes\Models\Project::all() as $project) {
            $project->owner_type = 'PatchNotes\\Models\\' . $project->owner_type;

            $project->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach(\PatchNotes\Models\Project::all() as $project) {
            $project->owner_type = str_replace('PatchNotes\\Models\\', '', $project->owner_type);

            $project->save();
        }
    }

}
