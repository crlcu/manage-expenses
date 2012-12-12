<?php
App::uses('UsersAppModel', 'Users.Model');

class UserDetail extends UsersAppModel {
	/**
	 * Model virtual fields
	 */
	var $virtualFields = array(
		'full_name'	=> 'CONCAT(UserDetail.first_name, " ", UserDetail.last_name)',
        //'age'       => 'TIMESTAMPDIFF(YEAR, UserDetail.birth_date, NOW())'
        'age'       => 'DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW()) - TO_DAYS(UserDetail.birth_date)), "%Y")'
	);
	
	/**
	 * model validation array
	 *
	 * @var array
	 */
	
	public $validate = array();
}