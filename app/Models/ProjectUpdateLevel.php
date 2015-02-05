<?php namespace PatchNotes\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'ProjectUpdateLevel'
 *
 * @property integer $level
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $id
 * @method static \Illuminate\Database\Query\Builder|\ProjectUpdateLevel whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ProjectUpdateLevel whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\ProjectUpdateLevel whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\ProjectUpdateLevel whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ProjectUpdateLevel whereUpdatedAt($value)
 */
class ProjectUpdateLevel extends Model {

    protected $table = 'project_updates_levels';

    protected $fillable = array('level', 'name');

} 
