<?php

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'SubscriptionLevel'
 *
 * @property integer $level
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class SubscriptionLevel extends Model {

    protected $table = 'subscription_levels';

    protected $fillable = array('level','name');

} 
