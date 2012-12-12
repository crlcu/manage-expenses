<?php
App::uses('CakeSession', 'Model/Datasource');

class ExpensesAppModel extends AppModel {
    
	public function beforeSave(){        
		$this->data[$this->name]['user_id'] = CakeSession::read('Authorization.User.id');
        $this->data[$this->name]['team_id'] = CakeSession::read('Authorization.Team.0.id');
        
		return true;
	}
}