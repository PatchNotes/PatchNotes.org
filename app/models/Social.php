<?php

use LaravelBook\Ardent\Ardent;

/**
 * An Eloquent Model: 'Social'
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $uid
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $access_token_secret
 * @property string $provider
 * @property string $oauth1_token_identifier
 * @property string $oauth1_token_secret
 * @property string $oauth2_access_token
 * @property string $oauth2_refresh_token
 * @property \Carbon\Carbon $oauth2_expires
 * @property-read \User $user
 */
class Social extends Ardent {

	protected $table = 'social';

	public function user() {
		return $this->belongsTo('User');
	}

}
