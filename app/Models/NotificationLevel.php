<?php namespace PatchNotes\Models;

use Illuminate\Database\Eloquent\Model;

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
 * @property string $key
 * @method static \Illuminate\Database\Query\Builder|\NotificationLevel whereKey($value) 
 */
class NotificationLevel extends Model {

    protected $table = 'notification_levels';

    protected $fillable = array('level', 'name', 'queue');

    public static function selectBox()
    {
        $options = [];

        $levels = self::all();
        foreach($levels as $level) {
            $options[$level->id] = $level->name;
        }

        return $options;
    }

} 
