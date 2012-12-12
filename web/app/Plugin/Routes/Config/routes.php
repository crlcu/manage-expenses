<?php	
    if ( !$routes = Cache::read('routes', 'routes') ){
		App::import("Model", "Routes.Route");
    	$routesModel = new Route();
        
        $routes = $routesModel->all(null, array(
            'order' => "length(Route.url) desc"
        ));
        
        Cache::write('routes', $routes, 'routes');
    }

    foreach ($routes as $route){
        $named_params = $route['NamedParams']; unset($route['NamedParams']);
		$params = $route['Params']; unset($route['Params']);
		$url = '/' . $route['Route']['url'];
		
        if ( empty($route['Route']['plugin'])) $route['Route']['plugin'] = false;
        unset($route['Route']['id'], $route['Route']['user_id'], $route['Route']['url'], $route['Route']['lastupdate']);
                
        foreach($named_params as $param){
            $route['Route'][$param['name']] = $param['value'];    
        }
		
		foreach($params as $param){
            array_push($route['Route'], $param['value']);
        }
        
        Router::connect($url . ( strlen($url) == 1 ?  '' : '/*'), $route['Route']);
    }