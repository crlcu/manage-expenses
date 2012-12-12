<?php
class SettingsAppController extends AppController {
	public $layout = 'Users.admin';
	
	/**
	 * Called before the controller action.  You can use this method to configure and customize components
	 * or perform logic that needs to happen before each controller action.
	 *
	 * @return void
	 */
	public function beforeFilter() {		
		parent::beforeFilter();
	}
}