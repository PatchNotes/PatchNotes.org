<?php

use LaravelBook\Ardent\Ardent;

/**
 * An Eloquent Model: 'ProjectManager'
 *
 * @property integer $user_id
 * @property integer $project_id
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Project $project
 * @property-read \User $user
 */
class ProjectManager extends Ardent {

	protected $table = 'project_managers';

	public function project() {
		return $this->belongsTo('Project');
	}

	public function user() {
		return $this->belongsTo('User');
	}

} 
