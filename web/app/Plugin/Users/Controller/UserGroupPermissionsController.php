<?php
App::uses('UsersAppController', 'Users.Controller');

class UserGroupPermissionsController extends UsersAppController {
	/**
	 * This controller uses following models
	 *
	 * @var array
	 */
	public $uses = array('Users.UserGroupPermission', 'Users.UserGroup');
	
	/**
	 * This controller uses following components
	 *
	 * @var array
	 */
	public $components=array('Users.ControllerList');
	
	/**
	 * Called before the controller action.  You can use this method to configure and customize components
	 * or perform logic that needs to happen before each controller action.
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();
		
		if(isset($this->Security) &&  ($this->request->is('ajax') || $this->action == 'update')){
			$this->Security->csrfCheck = false;
			$this->Security->validatePost = false;
		}
	}

	/**
	 * Used to display all permissions of site by Admin
	 *
	 * @access public
	 * @return array
	 */
	public function index( $active = -1 ) {
		
		$allControllers = $this->ControllerList->getControllers();
		
		$con = array();
		$conAll = $this->ControllerList->get();
		
		if ($active == -1) {
			$con = $conAll;
			$user_group_permissions = $this->UserGroupPermission->find('all', array('order' => array('controller', 'action')));
		} else {
			$user_group_permissions = $this->UserGroupPermission->find('all', array('order'=>array('controller', 'action'), 'conditions' => array('controller' => $allControllers[$active])));
			$con[$allControllers[$active]] = (isset($conAll[$allControllers[$active]])) ? $conAll[$allControllers[$active]] : array();
		}
		
		foreach ($user_group_permissions as $row) {
			$cont = $row['UserGroupPermission']['controller'];
			$act = $row['UserGroupPermission']['action'];
			$ugname = $row['UserGroup']['alias_name'];
			$allowed = $row['UserGroupPermission']['allowed'];
			$con[$cont][$act][$ugname] = $allowed;
		}
		
		$result = $this->UserGroup->getGroupNamesAndIds();
		$groups = array();
		
		foreach ($result as $row) {
			$groups[] = $row['alias_name'];
		}
		
		$groups = implode(',', $groups);
		
		$this->set('controllers', $con);
		$this->set('user_groups', $result);
		$this->set('groups', $groups);
		$this->set('active', $active);
		$this->set('allControllers', $allControllers);
	}
	
	/**
	 *  Used to update permissions of site using Ajax by Admin
	 *
	 * @access public
	 * @return integer
	 */
	public function update() {
		$this->autoRender = false;
		
        $response = array(
            'success' => false
        );
        
        $permission = $this->UserGroupPermission->permission( $this->data );
        $permission['UserGroupPermission'] = array_merge($permission['UserGroupPermission'], $this->data['UserGroupPermission']);
        
        if ( $this->UserGroupPermission->save($permission) ){
            $response['success'] = true;
            $this->__deleteCache();
        }
        
        return json_encode($response);
	}
	
	/**
	 * Used to delete cache of permissions and used when any permission gets changed by Admin
	 *
	 * @access private
	 * @return void
	 */
	private function __deleteCache() {		
		Cache::clear('permissions', 'permissions');	
	}
}