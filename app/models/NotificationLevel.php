<?php

use Illuminate\Database\Eloquent\Model;

class NotificationLevel extends Model {

    protected $table = 'notification_levels';

    protected $fillable = array('level','name');

} 
