<?php
class EventsController extends AppController {

	var $name = 'Events';
	public $paginate = array(
		'conditions' => array()
	);

	function index() {
		$this->Event->recursive = 0;
		if (!empty($this->params['named'])) {
			$this->paginate['conditions'] = isset($this->paginate['conditions']) ? $this->paginate['conditions'] : array();
			$this->paginate['conditions'] += $this->params['named'];
		}
		$this->set('events', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid event', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('event', $this->Event->read(null, $id));
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
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Event->delete($id)) {
			$this->Session->setFlash(__('Event deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Event was not deleted', true));
		$this->redirect(array('action' => 'index'));
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
}
?>