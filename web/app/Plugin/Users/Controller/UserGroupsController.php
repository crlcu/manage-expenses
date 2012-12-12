<?php
App::uses('UsersAppController', 'Users.Controller');

class UserGroupsController extends UsersAppController {
	/**
	 * This controller uses following models
	 *
	 * @var array
	 */
	public $uses = array('Users.UserGroup', 'Users.User');
	
	/**
	 * Called before the controller action.  You can use this method to configure and customize components
	 * or perform logic that needs to happen before each controller action.
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();
		
		if(isset($this->Security) &&  $this->request->is('ajax')){
			$this->Security->csrfCheck = false;
			$this->Security->validatePost = false;
		}
	}
	
	/**
	 * Used to view all groups by Admin
	 *
	 * @access public
	 * @return array
	 */
	public function index() {
		if ( $this->request->is('ajax') )
            $this->layout = 'ajaxify';
			
		$this->UserGroup->unbindModel( array('hasMany' => array('UserGroupPermission')));
		
        $this->paginate = array(
			'limit' => USERS_USER_GROUPS_INDEX_LIMIT
		);
        
        $this->data = empty($this->data)? $this->search : $this->data;
		$this->paginate = array_merge($this->paginate, array('conditions' => $this->UserGroup->search( $this->data )));
		
		$this->set('groups', $this->paginate());
	}
	
	/**
	 * Used to add group on the site by Admin
	 *
	 * @access public
	 * @return void
	 */
	public function add() {
		
	}
	
	/**
	 * Used to edit group on the site by Admin
	 *
	 * @access public
	 * @param integer $groupId group id
	 * @return void
	 */
	public function edit( $id = null ) {
		if ( $this->request->is('ajax') )
            $this->layout = 'ajaxify';
        
		$group = $this->UserGroup->findById( $id );
		
		if ( !$id || empty($group) ) {
			$this->Session->setFlash(__('Invalid group id!'), 'warning');
			$this->redirect(array('action' => 'index'));
		}
		
		if ( $this->request->is('put') ){
			if ( $this->UserGroup->saveAll( $this->data ) ){
				$this->Session->setFlash(__('User group successfully saved!'), 'success');
            
				$this->set('redirect', array('plugin' => 'users', 'controller' => 'users', 'action' => 'index'));
			}
		} else {
			$this->data = $this->UserGroup->findById( $id );
		}
	}
	
	/**
	 * Used to delete group on the site by Admin
	 *
	 * @access public
	 * @param integer $userId group id
	 * @return void
	 */
	public function delete( $id = null ) {
		if ( $this->request->is('ajax') )
            $this->layout = 'ajaxify';
            
		$group = $this->UserGroup->findById( $id );
		
		if ( !$id || empty($group) ) {
			$this->Session->setFlash(__('Invalid group id!'), 'warning');
			$this->redirect(array('action' => 'index'));
		}
		
		$users = $this->User->isUserAssociatedWithGroup( $id );
		
		if( $users ) {
			$this->Session->setFlash(__('Sorry some users are associated with this group. You cannot delete!'), 'warning');
			$this->redirect(array('action' => 'index'));
		}
		
		if ( $this->UserGroup->delete($id, false) ) {
			$this->Session->setFlash(__('Group is successfully deleted!'), 'success');
			$this->redirect(array('action' => 'index'));
		}
	}
}