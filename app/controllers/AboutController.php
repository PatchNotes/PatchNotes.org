<?php
namespace PatchNotes\Controllers;

class AboutController extends BaseController {

    public function getIndex() {

    }

    public function getTos() {
        return View::make('about/tos', array('bodyclass' => 'small-container'));
    }

    public function getPrivacy() {
        return View::make('about/privacy', array('bodyclass' => 'small-container'));
    }

} 
