<?php
/* Events Test cases generated on: 2010-09-02 13:09:30 : 1283452950*/
App::import('Controller', 'Events');
App::import('Component', 'Auth');

Mock::generate('AuthComponent');

class TestEventsController extends EventsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}

	function render($action = null, $file = null) {
		$this->renderedAction = $action;
	}
}

class EventsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.event', 'app.user');

	function startTest() {
		$this->Events =& new TestEventsController();
		$this->Events->constructClasses();
		$this->Events->Auth = new MockAuthComponent;
		$this->Events->Auth->enabled = true;
	}

	function endTest() {
		unset($this->Events);
		ClassRegistry::flush();
	}

	function testIndex() {
		$this->Events->params['action'] = 'index';
		$this->Events->params['url']['url'] = '/my_events/events/index';
		$this->Events->Auth->expectOnce('allow', array('index'));
		$this->Events->Auth->setReturnValue('user', 'user-1', array('id'));
		$this->Events->startupProcess();
		$this->Events->index();
		
		$fixture = new EventFixture;
		
		$data = array('Event' => $fixture->records[0]);
		$fixture = new UserFixture;
		$data += array('User' => $fixture->records[0]);
		$this->assertEqual($data, $this->Events->viewVars['events'][0]);
	}

	function testView() {
		$this->Events->params['action'] = 'view';
		$this->Events->Auth->setReturnValue('user', 'user-1', array('id'));
		$this->Events->startupProcess();
		$this->Events->view('event-1');
		$this->assertTrue(!empty($this->Events->viewVars['event']));
		$fixture = new EventFixture;
		
		$data = array('Event' => $fixture->records[0]);
		$fixture = new UserFixture;
		$data += array('User' => $fixture->records[0]);
		$this->assertEqual($data, $this->Events->viewVars['event']);
	}

	function testAdd() {
		$this->Events->params['action'] = 'add';
		$this->Events->data = array(
			'Event' => array(
				'title' => 'My new Event',
				'description' => 'a description',
				'date' => date('Y-m-d'),
				'time' => date('H:i:s')
			)
		);
		$this->Events->startupProcess();
		$this->Events->Auth->setReturnValue('user', 'user-1', array('id'));
		$this->Events->Auth->expectMinimumCallCount('user', 2);
		$this->Events->add();
		$event = $this->Events->Event->find('first', array('order' => 'Event.created DESC'));
		unset($event['Event']['created'], $event['Event']['modified'], $event['Event']['id']);
		$this->assertEqual($this->Events->data['Event'], $event['Event']);
		
		$this->assertEqual($this->Events->redirectUrl, array('action' => 'index'));
	}

	function testEdit() {

	}

	function testDelete() {

	}

	function testDay() {
		$this->Events->params['url']['url'] = '/my_events/events/day';
		$this->Events->startupProcess();
		$this->Events->day();
		$this->assertEqual($this->Events->action, 'index');
	}

}
?>