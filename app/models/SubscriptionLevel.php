<?php

use Illuminate\Database\Eloquent\Model;

class SubscriptionLevel extends Model {

    protected $table = 'subscription_levels';

    protected $fillable = array('level','name');

} 
