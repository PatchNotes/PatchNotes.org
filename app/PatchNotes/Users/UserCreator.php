<?php
namespace PatchNotes\Users;

use Sentry;
use User;
use UserOauth;

class UserCreator
{
    /**
     * @param $listener
     */
    public function __construct($listener)
    {
        $this->listener = $listener;
    }

    /**
     * Try to create a user from an array of oAuth user details
     *
     * @param  array $oauthDetails
     * @param  null  $currentUser
     * @return func
     */
    public function createUserFromOauth($oauthDetails, $currentUser = null)
    {
        // Look for the oauth user details (eg provider: github, user_id: 10) locally
        $oauthEntry = UserOauth::where('provider', $oauthDetails['provider'])
            ->where('provider_user_id', $oauthDetails['user_id'])
            ->first();

        // If the oauth has previously been created then...
        if ($oauthEntry) return $this->userExistsInOauth($oauthEntry);

        // If client is logged in (we have a local user id) then associate the oauth details with the user
        if ($currentUser) return $this->associateOauthWithUser($oauthDetails, $currentUser);

        $localUser = User::where('email', $oauthDetails['email'])
            ->first();

        // If the email address on the oauth account already exists, create an association
        if ($localUser) return $this->createOauthAttachedToUser($oauthDetails, $localUser);

        // Create a brand new user with a brand new oauth association
        return $this->registerUserFromOauth($oauthDetails);
    }

    /**
     * Specified user exists already in our oAuth store
     *
     * @param  object $oauthUser
     * @return func
     */
    public function userExistsInOauth($oauthUser)
    {
        if ($oauthUser->validated == 1) return $this->listener->oauthUserIsValid($oauthUser);

        return $this->listener->oauthUserRequiresValidation($oauthUser);
    }

    /**
     * Associate the oAuth entry with the provided userId
     *
     * @param  array $oauthDetails
     * @param  int   $userId
     * @return func
     */
    public function associateOauthWithUser($oauthDetails, $userId)
    {
        $oauth = $this->createOauth($oauthDetails, $userId, true);
        return $this->listener->oauthAssociationCreated($oauth);
    }

    /**
     * Create the oAuth entry and attach it to a local user account
     *
     * @param  array $oauthDetails
     * @param  int     $localUser
     * @return func
     */
    public function createOauthAttachedToUser($oauthDetails, $localUser)
    {
        $oauth = $this->createOauth($oauthDetails, $localUser->id, false);
        return $this->listener->oauthUserRequiresValidation($oauth);
    }

    /**
     * Register user using oAuth details
     *
     * @param  array $oauthDetails
     * @return func
     */
    public function registerUserFromOauth($oauthDetails)
    {
        try {
            $user = Sentry::register(array(
                'username'         => $oauthDetails['username'],
                'email'         => $oauthDetails['email'],
                'fullname'     => $oauthDetails['fullname'],
                'password'         => str_random(32),
                'activated'     => true
            ));

            $this->createOauth($oauthDetails, $user->id, true);

            return $this->listener->userRegisteredFromOauth($user);
        } catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
            return $this->listener->userRegistrationFromOauthFailed(['User with this login already exists']);
        }
    }

    /**
     * Store oAuth entry
     *
     * @param array $details
     * @param int   $userId
     * @param bool $validated
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function createOauth($details, $userId, $validated = false)
    {
        $oauth = UserOauth::create(array(
            'user_id'                 => $userId,
            'provider'                 => $details['provider'],
            'provider_user_id'         => $details['user_id'],
            'provider_user_details' => $details,
            'validated'             => $validated ? 1 : 0,
            'validation_key'        => str_random(32)
        ));

        return $oauth;
    }

    /**
     * Validate account connection from key
     *
     * @param $key
     * @return mixed
     */
    public function validateAuth($key)
    {
        $oauth = UserOauth::where('validation_key', $key)->firstOrFail();
        $oauth->validated = 1;
        $oauth->save();

        return $this->listener->accountValidated();
    }
}
