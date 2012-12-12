<?php
App::uses('UsersAppModel', 'Users.Model');
App::uses('CakeEmail', 'Network/Email');

class UserGroupPermission extends UsersAppModel {
	 public $belongsTo = array(
		  'UserGroup' => array(
			'dependent' => true,
			'className' => 'Users.UserGroup'
		)
	 );
     
     public function permission( $permission = array() ){
        $this->unbindModel(array(
            'belongsTo' => array('UserGroup')
        ));
        
        $permission = $this->find('first', array(
            'conditions' => array(
                'user_group_id' => $permission['UserGroupPermission']['user_group_id'],
                'controller' => $permission['UserGroupPermission']['controller'],
                'action' => $permission['UserGroupPermission']['action']
            ))
        );
        
        return $permission? $permission : array($this->name => array());
     }
}