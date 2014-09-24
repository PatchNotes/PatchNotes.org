<?php
namespace PatchNotes\OAuth;

interface ProviderInterface
{
    /**
     * Return users details from the OAuth provider in a consumable array
     * to be merged with the o
     *
     * @return array
     */
    public function userDetailsFromProvider();
}