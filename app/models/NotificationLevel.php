<?php

use LaravelBook\Ardent\Ardent;

/**
 * An Eloquent Model: 'NotificationLevel'
 *
 * @property integer $level
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $queue
 * @property integer $id
 * @method static \Illuminate\Database\Query\Builder|\NotificationLevel whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\NotificationLevel whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\NotificationLevel whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\NotificationLevel whereQueue($value)
 * @method static \Illuminate\Database\Query\Builder|\NotificationLevel whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NotificationLevel whereUpdatedAt($value)
 */
class NotificationLevel extends Ardent {

    protected $table = 'notification_levels';

    protected $fillable = array('level', 'name', 'queue');

} 
