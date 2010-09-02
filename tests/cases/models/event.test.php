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

	public function testFindComing() {
		$month = date('m');
		$data = array(
			array(
				'user_id' => 'user-1',
				'title' => 'Event 1',
				'date' => "2010-$month-29"
			),
			array(
				'user_id' => 'user-1',
				'title' => 'Event 2',
				'date' => "2010-$month-29"
			),
			array(
				'user_id' => 'user-1',
				'title' => 'Event 3',
				'date' => "2010-$month-29"
			),
			array(
				'user_id' => 'user-1',
				'title' => 'Event 4',
				'date' => "2010-$month-29"
			),
			array(
				'user_id' => 'user-1',
				'title' => 'Event 5',
				'date' => "2010-$month-30"
			),
			array(
				'user_id' => 'user-1',
				'title' => 'Event 6',
				'date' => "2011-$month-29"
			),
		);
		$this->assertTrue($this->Event->saveAll($data));
		$result = $this->Event->find('coming', array(
			'day' => 29,
			'month' => $month,
			'year' => 2010,
			'order' => 'Event.title'
		));
		$this->assertEqual(array('Event 1', 'Event 2', 'Event 3', 'Event 4'), Set::extract('/Event/title', $result));
		
		$result = $this->Event->find('coming', array('year' => 2011));
		$this->assertEqual(array('Event 6'), Set::extract('/Event/title', $result));
	}
}
?>