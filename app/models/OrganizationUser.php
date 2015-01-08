<?php

use LaravelBook\Ardent\Ardent;

/**
 * OrganizationUser
 *
 * @property-read \User $user
 * @property-read \Organization $organization
 * @property integer $user_id
 * @property integer $organization_id
 * @property boolean $creator
 * @method static \Illuminate\Database\Query\Builder|\OrganizationUser whereUserId($value) 
 * @method static \Illuminate\Database\Query\Builder|\OrganizationUser whereOrganizationId($value) 
 * @method static \Illuminate\Database\Query\Builder|\OrganizationUser whereCreator($value) 
 */
class OrganizationUser extends Ardent {

    protected $primaryKey = null;
    protected $table = 'organization_user';

    public $timestamps = false;

    public function user() {
        return $this->belongsTo('User');
    }

    public function organization() {
        return $this->belongsTo('Organization');
    }

}