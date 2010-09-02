<?php
/* Event Test cases generated on: 2010-09-02 10:09:08 : 1283441768*/
App::import('Model', 'Event');

class EventTestCase extends CakeTestCase {
	var $fixtures = array('app.event', 'app.user');

	function startTest() {
		$this->Event =& ClassRegistry::init('Event');
	}

	function endTest() {
		unset($this->Event);
		ClassRegistry::flush();
	}

	public function testValidationWithEmptyData() {
		$data = array();
		$this->Event->create($data);
		$result = $this->Event->validates();
		$this->assertFalse($result);
		$this->assertEqual(array_keys($this->Event->validationErrors), array('user_id', 'title'));
	}

	public function testValidationWithValidaData() {
		$data = array(
			'user_id' => 'user-1',
			'title' => 'my event',
			'date' => date('Y-m-d'),
			'time' => date('H:i:s')
		);
		$this->Event->create($data);
		$result = $this->Event->validates();
		$this->assertTrue($result);
		$this->assertEqual(array_keys($this->Event->validationErrors), array());
	}
	
}
?>