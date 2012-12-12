<?php
class PresentationsController extends PresentationsAppController {
	
	public function beforeFilter(){
		parent::beforeFilter();
	}
	
	public function index(){
		if ($this->Authorization->exist() ){
			$this->redirect( constant('USERS_USERS_LOGIN_' . strtoupper($this->Authorization->User->Group->name()) . '_REDIRECT_URL' ) );	
		}
		
		$this->set('title_for_layout', __('Home'));
	}
}