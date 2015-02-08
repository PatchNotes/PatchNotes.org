<?php

class ExampleTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testBasicExample()
	{
		$response = $this->call('GET', '/');
		echo($response->getContent());
		$this->assertEquals(200, $response->getStatusCode());
	}

}
