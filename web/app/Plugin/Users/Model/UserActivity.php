<?php
App::uses('UsersAppModel', 'Users.Model');

class UserActivity extends UsersAppModel {
	
	public $belongsTo = array(
        'User' => array(
			'className'	=> 'Users.User'
		)
    );

}