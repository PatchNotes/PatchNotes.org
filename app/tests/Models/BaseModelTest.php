<?php
namespace Models;

use Mockery;
use BaseModel;
use TestCase;
use Validator;

class BaseModelTest extends TestCase {

	protected $model;

	public function setUp() {
		parent::setUp();

		$this->model = $model = new BaseModel;
		$model::$rules = array(
			'name' => 'required'
		);
	}

	public function testReturnsTrueIfValidationPasses() {
		Validator::shouldReceive('make')->once()->andReturn(
			Mockery::mock(array('passes' => true))
		);

		$this->model->name = "A Name";
		$result = $this->model->validate();

		$this->assertTrue($result);
	}

	public function testSetsErrorsOnObjectIfValidationFails() {
		Validator::shouldReceive('make')->once()->andReturn(
			Mockery::mock(array('passes' => false, 'messages' => 'messages'))
		);

		$result = $this->model->validate();

		$this->assertFalse($result);
		$this->assertEquals('messages', $this->model->errors);
	}

}
