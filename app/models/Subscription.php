<?php

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model {

    public function user() {
        return $this->belongsTo('User');
    }

    public function project() {
        return $this->belongsTo('Project');
    }

    public function level() {
        return $this->hasOne('SubscriptionLevel');
    }

    public function subscriptionLevel() {
        return $this->hasOne('SubscriptionLevel');
    }

    public function notificationLevel() {
        return $this->hasOne('NotificationLevel');
    }

} 