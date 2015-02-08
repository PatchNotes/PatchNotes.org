<?php namespace PatchNotes\Http\Controllers;

class AboutController extends Controller
{

    public function getIndex()
    {

    }

    public function getTos()
    {
        return view('about/tos', ['bodyclass' => 'small-container']);
    }

    public function getPrivacy()
    {
        return view('about/privacy', ['bodyclass' => 'small-container']);
    }

}
