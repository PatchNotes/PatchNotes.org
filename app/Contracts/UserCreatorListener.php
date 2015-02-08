<?php namespace PatchNotes\Contracts;


interface UserCreatorListener {
    public function oauthUserIsValid($oauthUser);
    public function oauthUserRequiresValidation($oauthUser);
    public function oauthAssociationCreated($oauthUser);
    public function userRegisteredFromOauth($user);
    public function userRegistrationFromOauthFailed($errors);
}