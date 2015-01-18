<?php

/**
 * UserOauth
 *
 * @property-read \User $user
 * @property integer $id
 * @property integer $user_id
 * @property string $provider
 * @property integer $provider_user_id
 * @property string $provider_user_details
 * @property string $validation_key
 * @property boolean $validated
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\UserOauth whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\UserOauth whereUserId($value) 
 * @method static \Illuminate\Database\Query\Builder|\UserOauth whereProvider($value) 
 * @method static \Illuminate\Database\Query\Builder|\UserOauth whereProviderUserId($value) 
 * @method static \Illuminate\Database\Query\Builder|\UserOauth whereProviderUserDetails($value) 
 * @method static \Illuminate\Database\Query\Builder|\UserOauth whereValidationKey($value) 
 * @method static \Illuminate\Database\Query\Builder|\UserOauth whereValidated($value) 
 * @method static \Illuminate\Database\Query\Builder|\UserOauth whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\UserOauth whereUpdatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\UserOauth whereDeletedAt($value) 
 */
class UserOauth extends Eloquent
{
    protected $table = 'user_oauths';

    protected $fillable = ['user_id', 'provider', 'provider_user_id', 'provider_user_details', 'validated', 'validation_key'];

    public function user()
    {
        return $this->hasOne('User', 'id', 'user_id');
    }

    /**
     * Provided User Details Attribute Accessor
     *
     * @param string $value The JSON string stored in the social field of the table.
     *
     * @return array An array containing the social details
     */
    public function getProviderUserDetailsAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Provided User Details Attribute Mutator
     *
     * @param array $value The array containing the social details
     */
    public function setProviderUserDetailsAttribute($value)
    {
        $this->attributes['provider_user_details'] = json_encode($value);
    }
}