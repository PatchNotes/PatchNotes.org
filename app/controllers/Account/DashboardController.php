<?php
namespace Account;

use Sentry,
    User,
    View,
    Response;

class DashboardController extends BaseController {

    /**
     * @var User
     */
    private $user;

    public function __construct() {
        $this->beforeFilter('auth');

        $this->user = Sentry::getUser();
    }

    public function getIndex() {
        return View::make("account/dashboard/index");
    }

    public function getProfile() {

    }

    public function getSubscriptions() {
        $subscriptions = $this->user->subscriptions()->paginate(15);

        return View::make("account/dashboard/subscriptions", compact("subscriptions"));
    }

    public function postSubscriptions() {

    }

}
