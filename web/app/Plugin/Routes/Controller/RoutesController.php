<?php
class RoutesController extends RoutesAppController {
	
	public function beforeFilter(){
		parent::beforeFilter();
	}
	
	public function index(){		
        if ( $this->request->is('ajax') )
            $this->layout = 'ajaxify';
            
        $this->paginate = array(
            'limit' => ROUTES_ROUTES_INDEX_LIMIT,
			'order' => "length(Route.url) desc, Route.plugin, Route.controller, Route.action"
        );
        
        $this->data = empty($this->data)? $this->search : $this->data;
		$this->paginate = array_merge($this->paginate, array('conditions' => $this->Route->search( $this->data )));
        
		$this->set('routes', $this->paginate());
	}
	
	/**
	 * Used to add route on the site by Admin
	 *
	 * @access public
	 * @param integer $userId user id of user
	 * @return void
	 */
	public function add() {
        //if ( $this->request->is('ajax') )
            $this->layout = 'ajaxify';
			
		if ( $this->request->is('post') ){
			if ( $this->Route->saveAll( $this->data ) ){
				//delete routes cache file
				$this->__deleteCache();
				
				$this->Session->setFlash(__('Route successfully saved!'), 'success');
				//$this->redirect(array('action' => 'index'));
                $this->set('redirect', array('plugin' => 'routes', 'controller' => 'routes', 'action' => 'index'));
			}
		}
	}
	
	/**
	 * Used to edit routes on the site by Admin
	 *
	 * @access public
	 * @param integer $id setting id of setting
	 * @return void
	 */
	public function edit( $id = null ) {
        if ( $this->request->is('ajax') )
            $this->layout = 'ajaxify';
		
		$route = $this->Route->findById( $id );
		
		if ( !$id || empty($route) ) {
			$this->Session->setFlash(__('Invalid route id!'), 'warning');
			$this->redirect(array('action' => 'index'));
		}
		
		if ( $this->request->is('put') ){
			if ( $this->Route->saveAll( $this->data ) ){
				//delete routes cache file
				$this->__deleteCache();
				
				$this->Session->setFlash(__('Route successfully saved!'), 'success');
				
				//$this->redirect(array('action' => 'index'));
                $this->set('redirect', array('plugin' => 'routes', 'controller' => 'routes', 'action' => 'index'));
			}
		} else {
			$this->data = $route;
		}
	}
	
	public function delete( $id = null ){
		$route = $this->Route->findById( $id );
		
		if ( !$id || empty($route) ){
			$this->Session->setFlash(__('Invalid route id!'), 'warning');
			$this->redirect(array('action' => 'index'));	
		}
		
		if ( $this->Route->deleteAll( array('Route.id' => $route['Route']['id']) ) ){
			//delete routes cache file
			$this->__deleteCache();
			
			$this->Session->setFlash(__('Route successfully deleted!'), 'success');
		} else {
			$this->Session->setFlash(__('Route cannot be deleted!'), 'error');	
		}
		
		$this->redirect(array('action' => 'index'));
	}
	
	private function __deleteCache(){
		Cache::delete('routes', 'routes');
	}
}