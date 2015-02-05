<?php
namespace PatchNotes\Providers\OAuth;

use Config;
use OAuth\OAuth2\Service\GitHub;

class GitHubProvider extends AbstractProvider implements ProviderInterface
{
    /**
     * Provider identifier
     *
     * @var string
     */
    protected $provider = "GitHub";

    /**
     * Provider informal title
     *
     * @var string
     */
    public $title = "GitHub.com";

    /**
     * Return users GitHub profile information
     *
     * @return array
     */
    public function userDetailsFromProvider()
    {
        $details = json_decode($this->consumer->request('user'));
        $emails = json_decode($this->consumer->request('user/emails'));

        if(!isset($emails[0])) {
            \Log::error('Email[0] is not set.', $emails);
            return false;
        }

        return array(
            'user_id'         => $details->id,
            'username'         => $details->login,
            'fullname'    => $details->name,
            'email'         => $emails[0]
        );
    }
}