<?php

/**
 * An Eloquent Model: 'ProjectUpdateLevel'
 *
 * @property integer $level
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ProjectUpdateLevel extends BaseModel {

	protected $table = 'project_updates_levels';

	protected $fillable = array('level', 'name');

} 
