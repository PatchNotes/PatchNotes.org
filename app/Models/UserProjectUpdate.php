<?php namespace PatchNotes\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * UserProjectUpdate
 *
 * @property integer $user_id
 * @property integer $project_update_id
 * @property integer $project_update_level_id
 * @property integer $notification_level_id
 * @property string $emailed_at
 * @property string $seen_at
 * @property-read \User $user
 * @property-read \ProjectUpdate $projectUpdate
 * @method static \Illuminate\Database\Query\Builder|\UserProjectUpdate whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\UserProjectUpdate whereProjectUpdateId($value)
 * @method static \Illuminate\Database\Query\Builder|\UserProjectUpdate whereProjectUpdateLevelId($value)
 * @method static \Illuminate\Database\Query\Builder|\UserProjectUpdate whereNotificationLevelId($value)
 * @method static \Illuminate\Database\Query\Builder|\UserProjectUpdate whereEmailedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\UserProjectUpdate whereSeenAt($value)
 * @property integer $id
 * @property integer $project_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \NotificationLevel $notificationLevel
 * @method static \Illuminate\Database\Query\Builder|\UserProjectUpdate whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\UserProjectUpdate whereProjectId($value) 
 * @method static \Illuminate\Database\Query\Builder|\UserProjectUpdate whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\UserProjectUpdate whereUpdatedAt($value) 
 */
class UserProjectUpdate extends Model
{
    protected $table = 'user_project_updates';

    public function user() {
        return $this->belongsTo('PatchNotes\Models\User');
    }

    public function projectUpdate() {
        return $this->belongsTo('PatchNotes\Models\ProjectUpdate');
    }

    public function notificationLevel() {
        return $this->belongsTo('PatchNotes\Models\NotificationLevel');
    }

}