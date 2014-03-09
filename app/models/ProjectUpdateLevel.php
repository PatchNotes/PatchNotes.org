<?php

use LaravelBook\Ardent\Ardent;

/**
 * An Eloquent Model: 'ProjectUpdateLevel'
 *
 * @property integer $level
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ProjectUpdateLevel extends Ardent {

	protected $table = 'project_updates_levels';

	protected $fillable = array('level', 'name');

} 
