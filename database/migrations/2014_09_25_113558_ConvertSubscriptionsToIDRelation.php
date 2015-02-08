<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use PatchNotes\Models\NotificationLevel;
use PatchNotes\Models\ProjectUpdateLevel;
use PatchNotes\Models\Subscription;

class ConvertSubscriptionsToIDRelation extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('subscriptions', function(Blueprint $table) {
            $table->integer('project_update_level_id')->after('project_update_level')->unsigned();
            $table->integer('notification_level_id')->after('notification_level')->unsigned();

            $table->foreign('project_update_level_id')->references('id')->on('project_updates_levels');
            $table->foreign('notification_level_id')->references('id')->on('notification_levels');
        });

        $subscriptions = Subscription::get();

        foreach($subscriptions as $sub) {
            $projectUpdateLevel = ProjectUpdateLevel::where('level', $sub->project_update_level)->first();
            $notificationLevel = NotificationLevel::where('level', $sub->notification_level)->first();

            $sub->project_update_level_id = $projectUpdateLevel->id;
            $sub->notification_level_id = $notificationLevel->id;

            $sub->save();
        }

        Schema::table('subscriptions', function(Blueprint $table) {
            $table->dropUnique('subscriptions_project_id_user_id_project_update_level_unique');

            $table->dropColumn('notification_level');
            $table->dropColumn('project_update_level');

            $table->unique(array('project_id', 'user_id', 'project_update_level_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        return "There is no way back";
    }

}
