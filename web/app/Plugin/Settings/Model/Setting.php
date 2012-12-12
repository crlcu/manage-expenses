<?php
App::uses('SettingAppModel', 'Settings.Model');

class Setting extends SettingAppModel {
	public $belongsTo = array(
        'User' => array(
            'className' => 'Users.User'
        )
    );
    
    /**
	 *	model search conditions
	 */
	public $search = array(
        'Setting' => array(
            'description' => array(
                'condition' => 'like'
            ),
			'value' => array(
                'condition' => 'like'
            )
        ),
		'User' => array(
			'username' => array(
                'condition' => 'like'
            )
		)
    );
    
	public function all( $conditions = array() ){
		if ( !empty($conditions) )
			return $this->find('all', array('conditions' => $conditions));
		
		return $this->find('all');
	}
}