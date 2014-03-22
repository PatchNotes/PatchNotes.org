<?php

class UserOauth extends Eloquent
{
	protected $table = 'user_oauths';

	protected $fillable = ['user_id', 'provider', 'provider_user_id', 'provider_user_details', 'validated', 'validation_key'];

	public function user()
	{
		return $this->hasOne('User', 'id', 'user_id');
	}
}