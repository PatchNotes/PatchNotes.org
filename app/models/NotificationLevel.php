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
 */
class NotificationLevel extends Ardent {

    protected $table = 'notification_levels';

    protected $fillable = array('level', 'name', 'queue');

} 
