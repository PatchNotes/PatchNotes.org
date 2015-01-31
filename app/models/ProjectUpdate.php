<?php

use LaravelBook\Ardent\Ardent;

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
 * @property integer $project_update_level_id
 * @method static \Illuminate\Database\Query\Builder|\ProjectUpdate whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ProjectUpdate whereProjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\ProjectUpdate whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\ProjectUpdate whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\ProjectUpdate whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\ProjectUpdate whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\ProjectUpdate whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ProjectUpdate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ProjectUpdate whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ProjectUpdate whereProjectUpdateLevelId($value)
 */
class ProjectUpdate extends Ardent {

    protected $table = "project_updates";

    public function project() {
        return $this->belongsTo('Project');
    }

    public function author() {
        return $this->belongsTo('User', 'user_id');
    }

    public function getHrefAttribute() {
        return action('Projects\\UpdateController@show', array($this->project->owner->slug, $this->project->slug, $this->slug));
    }


} 
