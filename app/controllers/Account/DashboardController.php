<?php
namespace Account;

use Sentry;
use User;

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

	}

	public function getProfile() {

	}

	public function getSubscriptions() {
		$subscriptions = $this->user->subscriptions()->get();

		var_dump($subscriptions);
	}

	public function postSubscriptions() {

	}

} 
