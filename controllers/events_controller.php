<?php
class EventsController extends AppController {

	var $name = 'Events';
	public $paginate = array(
		'conditions' => array()
	);

	public function _setupAuth() {
		parent::_setupAuth();
		$this->Auth->allow('index');
	}

	function index() {
		$this->Event->recursive = 0;
		if (!empty($this->params['named'])) {
			$this->paginate['conditions'] = isset($this->paginate['conditions']) ? $this->paginate['conditions'] : array();
			$this->paginate['conditions'] += $this->params['named'];
		}
		$this->paginate['conditions']['user_id'] = $this->Auth->user('id');
		$this->set('events', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid event', true));
			$this->redirect(array('action' => 'index'));
		}
		$options = array('User' => array(
			'conditions' => array(
				'User.id' => $this->Auth->user('id')
			)
		));
		$event = $this->Event->find('first', array(
			'conditions' => array('Event.id' => $id),
			'contain' => $this->Event->commonContains($options)
		));
		$this->set('event', $event);
	}

	function add() {
		if (!empty($this->data)) {
			$this->Event->create();
			$this->data['Event']['user_id'] = $this->Auth->user('id');
			if ($this->Event->save($this->data)) {
				$this->Session->setFlash(__('The event has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Event->User->find('list');
		$this->set(compact('users'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid event', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Event->save($this->data)) {
				$this->Session->setFlash(__('The event has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Event->read(null, $id);
		}
		$users = $this->Event->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for event', true));
		}
		if ($this->Event->delete($id)) {
			$this->Session->setFlash(__('Event deleted', true));
		} else {
			$this->Session->setFlash(__('Event was not deleted', true));
		}
		if (!$this->RequestHandler->prefers('json')) {
			$this->redirect(array('action' => 'index'));
		}
		$this->set('id', $id);
	}

	public function day($day = null, $month = null, $year = null) {
		if (!$day) {
			$day = date('d');
		}
		$this->paginate = array('coming') + compact('day', 'month', 'year');
		$this->setAction('index');
	}
	
	public function month($month = null, $year = null) {
		$this->paginate = array('coming') + compact('month', 'year');
		$this->setAction('index');
	}

	public function hanger() {
		for ($i = 0; $i < 100000000; $i++) {
			
		}
		$this->setAction('index');
	}

	public function list_all($day = null, $month = null, $year = null) {
		if (!$day) {
			$day = date('d');
		}
		$events = $this->Event->cachedFindComing(compact('day', 'month', 'year'));
		debug($events); die;
	}
}
?>