<?php namespace PatchNotes\Models\Observers;


use PatchNotes\Models\Organization;
use PatchNotes\Models\User;
use PatchNotes\Models\UserPreference;

class OrganizationObserver
{

    public function creating($org)
    {
        $user = User::where('username', $org->slug)->first();

        if ($user) {
            return false;
        }

        return true;
    }

    public function updating($org)
    {
        $user = User::where('username', $org->slug)->first();

        if ($user) {
            return false;
        }

        return true;
    }
}