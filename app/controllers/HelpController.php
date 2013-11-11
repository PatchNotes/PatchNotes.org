<?php
namespace PatchNotes\Controllers;

use View;

class HelpController extends BaseController {

    public function getWelcome() {
        return View::make('help/welcome');
    }

} 
