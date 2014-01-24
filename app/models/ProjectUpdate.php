<?php

/**
 * An Eloquent Model: 'ProjectUpdate'
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property integer $subscription_level
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Project $project
 * @property-read \User $author
 * @property integer $level
 */
class ProjectUpdate extends Eloquent {

	protected $table = "project_updates";

	public function project() {
		return $this->belongsTo('Project');
	}

	public function author() {
		return $this->belongsTo('User', 'user_id');
	}

} 
