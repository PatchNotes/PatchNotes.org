<?php

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
class UserProjectUpdate extends Eloquent
{
    protected $table = 'user_project_updates';

    public function user() {
        return $this->belongsTo('User');
    }

    public function projectUpdate() {
        return $this->belongsTo('ProjectUpdate');
    }

    public function notificationLevel() {
        return $this->belongsTo('NotificationLevel');
    }

}