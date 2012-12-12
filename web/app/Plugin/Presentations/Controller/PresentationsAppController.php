<?php
class PresentationsAppController extends AppController {
	public $layout = 'Presentations.default';
	
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