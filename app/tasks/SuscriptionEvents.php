<?php
namespace PatchNotes\Events;

use Queue;
use ProjectUpdate;
use User;

class SuscriptionEvents {

	public function onUpdate(\Project $project, \ProjectUpdate $update) {
		// Get all users of the project
		$subsribers = $project->subscribers()->get();
		foreach($subsribers as $user) {
			// Push to the update queue
			Queue::push('SendUpdate', array($update, $user), $user->getSubscriptionLevel($project, $update->level)->toString());
		}
	}

	public function sendUpdate($data) {
		list($updateId, $userId) = $data;
		$update = ProjectUpdate::find($updateId);
		$user = User::find($userId);

		// Do mail thing
	}

	public function register($events) {
		$events->listen('project.update.create', 'PatchNotes\Events\SuscriptionEvents@onUpdate');
		$events->listen('project.update.send', 'PatchNotes\Events\SuscriptionEvents@sendUpdate');
	}

} 
