<?php

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Project'
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $content
 * @property string $site_url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\ProjectUpdate[] $updates
 * @property-read \Illuminate\Database\Eloquent\Collection|\ProjectManager[] $managers
 * @property-read \Illuminate\Database\Eloquent\Collection|\Subscription[] $subscribers
 */
class Project extends Model {

	/**
	 * Register a users subscription to a project.
	 *
	 * @param User $user
	 * @param $levels
	 * @return bool
	 */
	public function subscribe(User $user, $levels) {
		foreach ($levels as $level) {

			try {
				$subscription = new Subscription();

				$subscription->project_id = $this->id;
				$subscription->user_id = $user->id;
				$subscription->project_update_level = $level['project_update_level'];
				$subscription->notification_level = $level['notification_level'];

				$subscription->save();
			} catch (\Illuminate\Database\QueryException $e) {
				return false;
			}

		}

		return true;
	}

	/**
	 * Get a unique count of subscribers
	 *
	 * @return integer
	 */
	public function subscriberCount() {
		return count($this->subscribers()->groupBy('user_id')->get());
	}

	public function subscribers() {
		return $this->hasMany('Subscription');
	}

	public function updates() {
		return $this->hasMany('ProjectUpdate');
	}

	public function managers() {
		return $this->hasMany('ProjectManager');
	}

	public function isManager(User $user) {
		$managers = $this->managers;
		foreach ($managers as $manager) {
			if ($manager->user_id == $user->id) return true;
		}

		return false;
	}

}
