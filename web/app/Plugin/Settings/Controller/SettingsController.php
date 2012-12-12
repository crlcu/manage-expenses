<?php
class SettingsController extends SettingsAppController {
	
	public function beforeFilter(){
		parent::beforeFilter();
	}
	
	public function index(){		
        if ( $this->request->is('ajax') )
            $this->layout = 'ajaxify';
            
        $this->paginate = array(
            'limit' => SETTINGS_SETTINGS_INDEX_LIMIT
        );
        
        $this->data = empty($this->data)? $this->search : $this->data;
		$this->paginate = array_merge($this->paginate, array('conditions' => $this->Setting->search( $this->data )));
        
		$this->set('settings', $this->paginate());
	}
    
    /**
	 * Used to edit seting on the site by Admin
	 *
	 * @access public
	 * @param integer $id setting id of setting
	 * @return void
	 */
	public function edit( $id = null ) {
        if ( $this->request->is('ajax') )
            $this->layout = 'ajaxify';
        
		$setting = $this->Setting->findById( $id );
		
		if ( !$id || empty($setting) ) {
			$this->Session->setFlash(__('Invalid setting id!'), 'warning');
			$this->redirect(array('action' => 'index'));

		}    
		
		if ( $this->request->is('put') ){
			if ( $this->Setting->saveAll( $this->data ) ){
				$this->__deleteCache();
				
				$this->Session->setFlash(__('Setting successfully saved!'), 'success');
				
				//$this->redirect(array('action' => 'index'));
                $this->set('redirect', array('plugin' => 'settings', 'controller' => 'settings', 'action' => 'index'));
			}
		} else {
			$this->data = $setting;
		}
	}
	
	private function __deleteCache(){
		Cache::delete('settings', 'settings');
	}
}