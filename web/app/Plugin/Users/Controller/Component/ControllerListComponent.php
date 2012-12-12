<?php
class ControllerListComponent extends Component {
	/**
	 * Used to get all controllers with all methods for permissions
	 *
	 * @access public
	 * @return array
	 */
	public function get() {
		$controllerClasses = App::objects('Controller');
		$superParentActions = get_class_methods('Controller');
		$parentActions = get_class_methods('AppController');
		$parentActionsDefined = $this->_removePrivateActions($parentActions);
		$parentActionsDefined = array_diff($parentActionsDefined, $superParentActions);
		$controllers = array();
		
		foreach ($controllerClasses as $controller) {            
            if ( strpos($controller, 'AppController' ) === 0 )
                continue;
                
			$controllername = str_replace('Controller', '',$controller);
			$actions = $this->__getControllerMethods($controllername, $superParentActions, $parentActions);
			
			if ( !empty($actions) ) {
				$actions = array_values($actions);
				
				$controllers[$controllername] = $actions;
			}
            
            $controllers[$controllername]['plugin'] = false;
		}
		
		$plugins = App::objects('plugins');
		
		foreach ($plugins as $plugin) {
			$pluginAppContMethods = array();
			$pluginControllerClasses = App::objects($plugin.'.Controller');
			
			foreach ($pluginControllerClasses as $controller) {
				if( strpos($controller, 'AppController' ) !== false ) {
					$controllername = str_replace('Controller', '', $controller);
					$pluginAppContMethods = $this->__getControllerMethods($controllername, $superParentActions, $parentActions, $plugin);
				}
			}
            
			foreach ($pluginControllerClasses as $controller) {
                if ( strpos($controller, 'AppController' ) > 0 )
                    continue;
                
				$controllername = str_replace('Controller', '', $controller);
				$actions = $this->__getControllerMethods($controllername, $superParentActions, $parentActions, $plugin);
                $actions =  array_diff($actions, $pluginAppContMethods);
				
				if ( !empty($actions) ) {
					$actions = array_values($actions);
					$controllers[$controllername] = $actions;
				}
                
                $controllers[$controllername]['plugin'] = $plugin;
            }
		}
        
		return $controllers;
	}
	
	/**
	 * Used to delete private actions from list of controller's methods
	 *
	 * @access private
	 * @param array $actions Controller's action
	 * @return array
	 */
	private function _removePrivateActions($actions) {
		foreach ($actions as $k => $v) {
			if ($v{0} == '_') {
				unset($actions[$k]);
			}
		}
		
		return $actions;
	}
	
	/**
	 * Used to get methods of controller
	 *
	 * @access private
	 * @param string $controllername Controller name
	 * @param array $superParentActions Controller class methods
	 * @param array $parentActions App Controller class methods
	 * @param string $p plugin name
	 * @return array
	 */
	private function __getControllerMethods($controllername, $superParentActions, $parentActions, $p = null) {
		if (empty($p)) {
			App::import('Controller', $controllername);
		} else {
			App::import('Controller', $p.'.'.$controllername);
		}
		
		$actions = get_class_methods($controllername."Controller");
		
		if (!empty($actions)) {
			$actions = $this->_removePrivateActions($actions);
			$actions = ($controllername == 'App') ? array_diff($actions, $superParentActions) : array_diff($actions, $parentActions);
		}
		
		return $actions;
	}
	
	/**
	 *  Used to get controller's list
	 *
	 * @access public
	 * @return array
	 */
	public function getControllers() {				
		$controllerClasses = App::objects('Controller');
        
		foreach ($controllerClasses as $key => $controller) {
            if ( strpos($controller, 'AppController' ) === 0 ){
                unset($controllerClasses[$key]);
                continue;        
            }
             
            $controllerClasses[$key] = str_replace('Controller', '', $controller);
		}
		
		$plugins = App::objects('plugins');
		
		foreach ($plugins as $plugin) {
			$pluginControllerClasses = App::objects($plugin.'.Controller');
			
			foreach ($pluginControllerClasses as $controller) {
                if ( strpos($controller, 'AppController' ) === false )
                    $controllerClasses[] = str_replace('Controller', '', $controller);
			}
		}
		
		$controllerClasses[-1] = __("All");
		
		//sort controllers by key
		ksort($controllerClasses);
        
		return $controllerClasses;
	}
}