<?php
/* User Test cases generated on: 2010-09-02 11:09:28 : 1283444008*/
App::import('Model', 'User');

class UserTestCase extends CakeTestCase {
	var $fixtures = array('app.user', 'app.event');

	function startTest() {
		$this->User =& ClassRegistry::init('User');
	}

	function endTest() {
		unset($this->User);
		ClassRegistry::flush();
	}
	

	public function testValidationWithEmptyData() {
		$data = array();
		$this->User->create($data);
		$result = $this->User->validates();
		$this->assertFalse($result);
		$this->assertEqual(array_keys($this->User->validationErrors), array('username', 'password'));
	}
	
	public function testValidationWithEmptyUsername() {
		$data = array('username' => '', 'password' => '');
		$this->User->create($data);
		$result = $this->User->validates();
		$this->assertFalse($result);
		$this->assertEqual(array_keys($this->User->validationErrors), array('username', 'password'));
	}

	public function testValidationWithShortPassword() {
		$data = array('username' => 'joe', 'password' => '123');
		$this->User->create($data);
		$result = $this->User->validates();
		$this->assertFalse($result);
		$this->assertEqual(array_keys($this->User->validationErrors), array('password'));
	}

	public function testValidationWithValidData() {
		$data = array('username' => 'joe', 'password' => '123456');
		$this->User->create($data);
		$result = $this->User->validates();
		$this->assertTrue($result);
		$this->assertEqual(array_keys($this->User->validationErrors), array());
	}

	public function testValidationWithDuplicateUsername() {
		$data = array('username' => 'user-1', 'password' => '123456');
		$this->User->create($data);
		$result = $this->User->validates();
		$this->assertFalse($result);
		$this->assertEqual(array_keys($this->User->validationErrors), array('username'));
	}
}
?>