<?php
/* User Fixture generated on: 2010-09-02 11:09:28 : 1283444008 */
class UserFixture extends CakeTestFixture {
	var $name = 'User';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20),
		'password' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 70),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 'user-1',
			'username' => 'user-1',
			'password' => 'Lorem ipsum dolor sit amet',
			'created' => '2010-09-02 11:13:28',
			'modified' => '2010-09-02 11:13:28'
		),
	);
}
?>