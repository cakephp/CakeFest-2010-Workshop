<?php
App::import('Core', 'ClassRegistry');
class DatabaseLog {

	protected $model = null;
	public function __construct($options = array()) {
		$this->model = ClassRegistry::init($options['model']);
	}

	public function write($type, $message) {
		$this->model->save(compact('type', 'message'));
	}
}