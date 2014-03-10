<?php

use LaravelBook\Ardent\Ardent;

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
class Project extends Ardent {

	public static $rules = array(
		'name' => 'required',
		'slug' => 'required|unique:projects',
		'site_url' => 'required|url',
		'description' => 'required',
	);

    /**
     * @param $participant
     * @return bool|User|Organization
     * @throws Exception
     */
    public static function resolveParticipant($participant) {
        $user = User::where('username', $participant)->first();
        $organization = Organization::where('slug', $participant)->first();

        if($user && $organization) {
            throw new Exception("Found user and org record for {$participant}.");
        } elseif($user && !$organization) {
            return $user;
        } elseif(!$user && $organization) {
            return $organization;
        }

        return false;
    }

    /**
	 * Register a users subscription to a project.
	 *
	 * @param User $user
	 * @param $levels
	 * @return bool
	 */
	public function subscribe(User $user, $levels = array()) {
		if(empty($levels)) $levels = $user->getDefaultLevels();
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

	public function unsubscribe(User $user) {
		$subscriptions = Subscription::where('user_id', $user->id)->where('project_id', $this->id)->get();

		foreach($subscriptions as $subscription) {
			$subscription->delete();
		}

		return true;
	}

	public function isSubscriber(User $user) {
		return (boolean)Subscription::where('user_id', $user->id)->where('project_id', $this->id)->first();
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

    public function owner() {
        return $this->morphTo();
    }

}
