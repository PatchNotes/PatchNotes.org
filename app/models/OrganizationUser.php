<?php

use LaravelBook\Ardent\Ardent;

class OrganizationUser extends Ardent {

    protected $table = 'organization_users';

    public function user() {
        return $this->belongsTo('User');
    }

    public function organization() {
        return $this->belongsTo('Organization');
    }

}