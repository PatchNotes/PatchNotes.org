<?php
namespace PatchNotes\OAuth;

use Config;
use OAuth\OAuth2\Service\GitHub;

class GitHubProvider extends AbstractProvider implements ProviderInterface
{
	/**
	 * OAuth provider name
	 *
	 * @var string
	 */
	protected $provider = "GitHub";

	/**
	 * Return users GitHub profile information
	 *
	 * @return array
	 */
	public function userDetailsFromProvider()
	{
		$details = json_decode($this->consumer->request('user'));

		return array(
			'user_id' 		=> $details->id,
			'username' 		=> $details->login,
			'name'			=> $details->name,
			'email' 		=> $details->email
		);
	}
}