<?php

use LaravelBook\Ardent\Ardent;

/**
 * Class Subscription
 *
 * Subscriptions are PatchNote's core, you subscribe to do anything on the website.
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $project_id
 * @property integer $project_update_level_id
 * @property integer $notification_level_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \User $user
 * @property-read \Project $project
 * @property-read \ProjectUpdateLevel $subscriptionLevel
 * @property-read \NotificationLevel $notificationLevel
 */
class Subscription extends Ardent {

    public function user() {
        return $this->belongsTo('User');
    }

    public function project() {
        return $this->belongsTo('Project');
    }

    public function projectUpdateLevel() {
        return $this->belongsTo('ProjectUpdateLevel');
    }

    public function notificationLevel() {
        return $this->belongsTo('NotificationLevel');
    }

}
