<?php namespace PatchNotes\Models;

use Illuminate\Database\Eloquent\Model;

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
 * @property-read \ProjectUpdateLevel $projectUpdateLevel
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereProjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereProjectUpdateLevelId($value)
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereNotificationLevelId($value)
 */
class Subscription extends Model
{

    public function user()
    {
        return $this->belongsTo('PatchNotes\Models\User');
    }

    public function project()
    {
        return $this->belongsTo('PatchNotes\Models\Project');
    }

    public function projectUpdateLevel()
    {
        return $this->belongsTo('PatchNotes\Models\ProjectUpdateLevel');
    }

    public function notificationLevel()
    {
        return $this->belongsTo('PatchNotes\Models\NotificationLevel');
    }

}
