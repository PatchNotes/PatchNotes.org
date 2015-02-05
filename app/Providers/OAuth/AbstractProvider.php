<?php
namespace PatchNotes\Providers\OAuth;

use OAuth\Common\Consumer\Credentials;
use OAuth\Common\Http\Client\CurlClient;
use OAuth\Common\Http\Exception\TokenResponseException;
use OAuth\Common\Storage\Session;
use OAuth\ServiceFactory;

abstract class AbstractProvider
{
    public $title = "OAuth Provider";

    /**
     * OAuth consumer
     *
     * @var \OAuth\Common\Service\ServiceInterface
     */
    protected $consumer;

    /**
     * Access token from the OAuth provider for the authorized user
     *
     * @var \OAuth\Common\Token\AbstractToken
     */
    protected $userAccessToken;


    public function __construct($callback = null, $scope = null, $id = null, $secret = null)
    {
        $id = $id ?: config('oauth.GitHub.client_id');
        $secret = $secret ?: config('oauth.GitHub.client_secret');
        $callback = $callback ?: config('oauth.GitHub.callback');
        $scope = $scope ?: config('oauth.GitHub.scope');
        $callback = url($callback);

        $serviceFactory = new ServiceFactory();
        $storage = new Session();
        $credentials = new Credentials($id, $secret, $callback);
        $serviceFactory->setHttpClient(new CurlClient());

        $this->consumer = $serviceFactory->createService($this->provider, $credentials, $storage, $scope);
    }

    /**
     * Authorization URI for the provider
     *
     * @return string
     */
    public function getAuthorizationUri()
    {
        return (string) $this->consumer->getAuthorizationUri();
    }

    /**
     * Authorize user with provider
     *
     * @param $code string
     * @return bool
     */
    public function authorizeUser($code)
    {
        try {
            $token = $this->consumer->requestAccessToken($code);
            $this->userAccessToken = $token->getAccessToken();
            return true;
        } catch (TokenResponseException $e) {
            return false;
        }
    }

    /**
     * User details from OAuth provider
     *
     * @return array
     */
    public function getUserDetails()
    {
        $details = array_merge($this->userDetailsFromProvider(), array(
            'provider' => $this->provider,
            'access_token' => $this->userAccessToken,
        ));

        // TODO: Ensure that $details now contains the mandatory values
        // username, email, name and user_id.

        return $details;
    }
}