<?php namespace PatchNotes\Http\Controllers;

class HelpController extends Controller
{

    public function getWelcome()
    {
        return view('help.welcome');
    }

} 
