<?php

class ExampleTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testBasicExample()
	{
		var_dump(scandir(public_path('build/js')));
		$response = $this->call('GET', '/');
		echo($response->getContent());
		$this->assertEquals(200, $response->getStatusCode());
	}

}
