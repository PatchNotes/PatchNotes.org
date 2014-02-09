<?php

/**
 * An Eloquent Model: 'NotificationLevel'
 *
 * @property integer $level
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class NotificationLevel extends BaseModel {

	protected $table = 'notification_levels';

	protected $fillable = array('level', 'name', 'queue');

} 
