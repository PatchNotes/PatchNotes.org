<?php
namespace PatchNotes\OAuth;

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

        list($first_name, $last_name) = explode(" ", $details->name);

        return array(
            'user_id'         => $details->id,
            'username'         => $details->login,
            'first_name'    => $first_name,
            'last_name'        => $last_name,
            'email'         => $details->email
        );
    }
}