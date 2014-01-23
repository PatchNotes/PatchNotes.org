<?php

class PagesTest extends TestCase {

	public function testHomepage() {
		$this->call('GET', '/');

		$this->assertResponseOk();
	}

	public function testAboutTos() {
		$this->call('GET', '/about/tos');

		$this->assertResponseOk();
	}

	public function testAboutPrivacy() {
		$this->call('GET', '/about/privacy');

		$this->assertResponseOk();
	}

}
