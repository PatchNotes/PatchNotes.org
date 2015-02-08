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
		var_dump($response);
		$this->assertEquals(200, $response->getStatusCode());
	}

}
