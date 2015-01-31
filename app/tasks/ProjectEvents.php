<?php
namespace PatchNotes\Events;

use Config;
use Queue;
use ProjectUpdate;
use Subscription;
use User;
use UserProjectUpdate;

class ProjectEvents {

    /**
     * This event is triggered when a project pushes out an update.
     * We use this for queueing up updates for users
     *
     * @param \Project $project
     * @param ProjectUpdate $update
     */
    public function onUpdate(\Project $project, \ProjectUpdate $update) {
        // Get all users of the project
        $subs = Subscription::where('project_id', $project->id)->where('project_update_level_id', $update->project_update_level_id)->get();
        foreach($subs as $sub) {
            $userProjectUpdate = new UserProjectUpdate();
            $userProjectUpdate->user_id = $sub->user_id;
            $userProjectUpdate->project_id = $project->id;
            $userProjectUpdate->project_update_id = $update->id;
            $userProjectUpdate->project_update_level_id = $sub->project_update_level_id;
            $userProjectUpdate->notification_level_id = $sub->notification_level_id;
            $userProjectUpdate->save();
        }
    }

    public function sendUpdate($job, $data) {
        list($updateId, $userId) = $data;
        $update = ProjectUpdate::find($updateId);
        $user = User::find($userId);

        // Do mail thing

        $job->delete();
    }

    public function subscribe($events) {
        $events->listen('project.update.create', 'PatchNotes\Events\ProjectEvents@onUpdate');
        $events->listen('project.update.send', 'PatchNotes\Events\ProjectEvents@sendUpdate');
    }

}
