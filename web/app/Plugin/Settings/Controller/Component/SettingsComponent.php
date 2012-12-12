<?php
class SettingsComponent extends Component {
	function __construct(ComponentCollection $collection, $settings = array()) {
		parent::__construct($collection, $settings);
	}
	
	function initialize($controller) {
	}

	function startup(&$controller = null) {
		$this->loadConstants();
	}
	
	public function loadConstants(){
        if ( !$settings = Cache::read('settings', 'settings') ){
    		App::import('Model', 'Settings.Setting');
    		$setting = new Setting();
    		$settings = $setting->all();
            
            Cache::write('settings', $settings, 'settings');
        }
        
		for ($i = sizeof($settings) - 1; $i >=0; $i--){
            $constant = $this->constantName(array(
                $settings[$i]['Setting']['plugin'], 
                $settings[$i]['Setting']['controller'],
                $settings[$i]['Setting']['action'],
                $settings[$i]['Setting']['setting']
            ));

            if ( defined($constant) )
				continue;
            
			define($constant, $settings[$i]['Setting']['value']);
		}
	}
    
    private function constantName( $array = array() ){
        return strtoupper( implode('_', array_filter($array)) );
    }
}