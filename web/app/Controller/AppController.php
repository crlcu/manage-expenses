<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');
App::uses('File', 'Utility');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array(
        'Routes.Routes',
        'Settings.Settings',
        'Users.Authorization',
        'Expenses.Expenses',
        'Presentations.Presentations',
        'Session'
    );
    
    public function beforeFilter(){
		Configure::write('Config.language', 'fre');
    }
	
	public function beforeRender(){
		if ( $this->Authorization->exist() ){
			$this->set('payment_categories', $this->Expenses->Payment->categories());
			$this->set('receivable_categories', $this->Expenses->Receivable->categories());
			
			$payments = $this->Expenses->Payment->total();
			$receivables = $this->Expenses->Receivable->total();
			$cash = $receivables - $payments;
			
			$this->set('statistics', compact('payments', 'receivables', 'cash'));	
		}
	}
}