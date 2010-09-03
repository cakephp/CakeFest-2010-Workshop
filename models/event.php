<?php
class Event extends AppModel {
	var $name = 'Event';
	var $displayField = 'title';
	var $validate = array(
		'user_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'date' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'time' => array(
			'time' => array(
				'rule' => array('time'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public $_findMethods = array('coming' => true);

	public function _findComing($state, $query, $results = array()) {
		if ($state == 'before') {
			$this->getDataSource()->begin($this);
			if (empty($query['month'])){
				$query['month'] = date('m');
			}
			if (empty($query['year'])){
				$query['year'] = date('Y');
			}
			$startDay = '01';
			$endingDay = 31;
			if (!empty($query['day'])) {
				$startDay = $endingDay = $query['day'];
			}
			$query['conditions']['Event.date >='] = $query['year'] . '-' . $query['month'] . '-' . $startDay;
			$query['conditions']['Event.date <='] = $query['year'] . '-' . $query['month'] . '-' . $endingDay;
			
			if (!empty($query['operation'])) {
				return $this->_findCount($state, $query, $results);
			}
			return $query;
		}
			$this->getDataSource()->commit($this);
			if (!empty($query['operation'])) {
				return $this->_findCount($state, $query, $results);
			}
		return $results;
	}

	public function paginateCount($conditions = array(), $recursive = 0, $extra = array()) {
		$parameters = compact('conditions');
		if (isset($extra['type'])) {
			$extra['operation'] = 'count';
			return $this->find($extra['type'], array_merge($parameters, $extra));
		} else {
			return $this->find('count',array_merge($parameters, $extra));
		}
	}
	

	public function cachedFindComing($options) {
		$key = 'find_coming_' . md5(serialize($options));
		if (!$events = Cache::read($key, 'coming')) {
			$events = $this->find('coming', $options);
			Cache::write($key, $events, 'coming');
		}

		return $events;
	}

	public function invalidateCache() {
		Cache::clear(false, 'coming');
	}

	public function afterSave($created) {
		parent::afterSave($created);
		$this->invalidateCache();
	}
	public function afterDelete() {
		parent:afterDelete();
		$this->invalidateCache();
	}
	
	public function commonContains($options = array()) {
		return array_merge(array('User'), $options);
	}
	
	
	
	
}
?>