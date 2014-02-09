<?php
namespace PatchNotes\Events;

use Config;
use Queue;
use ProjectUpdate;
use Subscription;
use User;

class ProjectEvents {

	public function onUpdate(\Project $project, \ProjectUpdate $update) {
		// Get all users of the project
		$subs = Subscription::where('project_id', $project->id)->where('project_update_level', $update->level)->get();
		foreach($subs as $sub) {
			$notificationLevel = $sub->user->getNotificationLevel($update);
			$queue = Config::get('patchnotes.aws.queue.' . $notificationLevel->queue);

			// Push to the update queue
			Queue::push('SendUpdate', array($update->id, $sub->user->id), $queue);
		}
	}

	public function sendUpdate($updateId, $userId) {
		$update = ProjectUpdate::find($updateId);
		$user = User::find($userId);

		// Do mail thing
	}

	public function subscribe($events) {
		$events->listen('project.update.create', 'PatchNotes\Events\ProjectEvents@onUpdate');
		$events->listen('project.update.send', 'PatchNotes\Events\ProjectEvents@sendUpdate');
	}

} 
