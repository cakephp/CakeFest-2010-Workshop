<?php

class EventRoute extends CakeRoute {
	
	public function parse($url) {
		$params = parent::parse($url);
		foreach (array('year', 'month', 'day') as $param) {
			if (empty($params[$param])) {
				return false;
			}
		}

		$event = ClassRegistry::init('Event')->cachedFindComing(array(
			'conditions' => array('Event.id' => $params['id'])
		) + array('year' => $params['year'], 'month' => $params['month'], 'day' => $params['day']));

		if (!$event) {
			return  false;
		}
		
		foreach (array('year', 'month', 'day') as $param) {
			unset($params[$param]);
		}
		$params['pass'][] = $params['id'];
		return $params;
	}

	public function match($url) {
		if ($url['controller'] != 'events' || $url['action'] != 'view' || empty($url[0])) {
			return false;
		}
		
		$id = $url[0];
		$event = ClassRegistry::init('Event')->cachedFindComing(array(
			'conditions' => array('Event.id' => $id)
		));
		$event = current($event);

		$date = strtotime($event['Event']['date']);
		$resultingUrl = array_merge($url, array(
			'year' => date('Y', $date),
			'month' => date('m', $date),
			'day' => date('d', $date),
			'id' => $id
		));

		unset($resultingUrl[0]);
		return parent::match($resultingUrl);
	}
}