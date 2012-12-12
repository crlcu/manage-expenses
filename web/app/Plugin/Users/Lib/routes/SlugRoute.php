<?php
App::uses('CakeRoute', 'Routing/Route');
App::uses('Component', 'Controller');

class SlugRoute extends CakeRoute {
	function parse($url) {
		$params = parent::parse($url);
		if(isset($params['slug'])) {
			$username = $params['slug'];
			App::import("Component", "Users.ControllerList");
			
			$contList = new ControllerListComponent(new ComponentCollection());
			$conts = $contList->getControllers();
			unset($conts[-2]);
			unset($conts[-1]);
			$conts = array_map('strtolower', $conts);
			$usernameTmp =strtolower(str_replace(' ','',ucwords(str_replace('_',' ',$username))));
			if(!in_array($usernameTmp, $conts)) {
				$plugins = App::objects('plugins');
				$plugins = array_map('strtolower', $plugins);
				if(in_array($usernameTmp, $plugins)) {
					return false;
				}
				$customRoutes = Router::$routes;
				$usernameTmp ='/'.$username;
				foreach($customRoutes as $customRoute) {
					if(strpos(strtolower($customRoute->template), strtolower($usernameTmp)) !==false) {
						return false;
					}
				}

				App::import("Model", "Users.User");
				$userModel = new User;
				$isUser = $userModel->findByUsername($params['slug']);
				if ($isUser) {
					$params['pass'][0] = $params['slug'];
					return $params;
				}
			}
			return false;
		}
		return false;
	}
}
?>