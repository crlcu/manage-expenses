<?php
class UsersAppController extends AppController {
	public $layout = 'Users.admin';
    
	/**
	 * This controller uses following components
	 */
	public $components = array('Session', 'Security');
	
	/**
	 * Called before the controller action.  You can use this method to configure and customize components
	 * or perform logic that needs to happen before each controller action.
	 *
	 * @return void
	 */
	public function beforeFilter() {		
		parent::beforeFilter();

		$this->Security->blackHoleCallback = 'handleBlackHole';

		if($this->Session->check('Authorization.FacebookLogin')) {
			$this->Session->delete('Authorization.FacebookLogin');
			
			if($this->Session->check('Authorization.FacebookChangePass')) {
				$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'changePassword'));
			} else {
				$LoginRedirect = $this->Session->read('Authorization.Redirect');
				$this->Session->delete('Authorization.Redirect');
				
				$redirect = (!empty($LoginRedirect)) ? $LoginRedirect : USERS_LOGIN_REDIRECT_URL;
				$this->redirect($redirect);
			}
		}
        
		if($this->Session->check('Authorization.TwitterLogin')) {
			$this->Session->delete('Authorization.TwitterLogin');
            
			if($this->Session->check('Authorization.TwitterChangePass')) {
				$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'changePassword'));
			} else {
				$LoginRedirect=$this->Session->read('Authorization.Redirect');
				$this->Session->delete('Authorization.Redirect');
				$redirect = (!empty($LoginRedirect)) ? $LoginRedirect : USERS_LOGIN_REDIRECT_URL;
				$this->redirect($redirect);
			}
		}
        
		if($this->Session->check('Authorization.GmailLogin')) {
			$this->Session->delete('Authorization.GmailLogin');
            
			if($this->Session->check('Authorization.GmailChangePass')) {
				$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'changePassword'));
			} else {
				$LoginRedirect=$this->Session->read('Authorization.Redirect');
				$this->Session->delete('Authorization.Redirect');
				$redirect = (!empty($LoginRedirect)) ? $LoginRedirect : USERS_LOGIN_REDIRECT_URL;
				$this->redirect($redirect);
			}
		}
        
		if($this->Session->check('Authorization.LinkedinLogin')) {
			$this->Session->delete('Authorization.LinkedinLogin');
            
			if($this->Session->check('Authorization.LinkedinChangePass')) {
				$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'changePassword'));
			} else {
				$LoginRedirect=$this->Session->read('Authorization.Redirect');
				$this->Session->delete('Authorization.Redirect');
				$redirect = (!empty($LoginRedirect)) ? $LoginRedirect : USERS_LOGIN_REDIRECT_URL;
				$this->redirect($redirect);
			}
		}
        
		if($this->Session->check('Authorization.FoursquareLogin')) {
			$this->Session->delete('Authorization.FoursquareLogin');
            
			if($this->Session->check('Authorization.FoursquareChangePass')) {
				$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'changePassword'));
			} else {
				$LoginRedirect=$this->Session->read('Authorization.Redirect');
				$this->Session->delete('Authorization.Redirect');
				$redirect = (!empty($LoginRedirect)) ? $LoginRedirect : USERS_LOGIN_REDIRECT_URL;
				$this->redirect($redirect);
			}
		}
        
		if($this->Session->check('Authorization.YahooLogin')) {
			$this->Session->delete('Authorization.YahooLogin');
            
			if($this->Session->check('Authorization.YahooChangePass')) {
				$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'changePassword'));
			} else {
				$LoginRedirect = $this->Session->read('Authorization.Redirect');
				$this->Session->delete('Authorization.Redirect');
				$redirect = (!empty($LoginRedirect)) ? $LoginRedirect : USERS_LOGIN_REDIRECT_URL;
				$this->redirect($redirect);
			}
		}
	}
	
	public function handleBlackHole($type) {
		$this->redirect(array('plugin' => $this->params['plugin'], 'controller' => $this->params['controller'], 'action' => $this->params['action']));
	}
}