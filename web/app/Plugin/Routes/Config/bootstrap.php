<?php	
    // In development mode, caches should expire quickly.
    $duration = '+999 days';
    if (Configure::read('debug') >= 1) {
    	$duration = '+10 seconds';
    }

    Cache::config('routes', array(
		'engine' => 'File',
		'duration'=> $duration,
		'path' => CACHE . 'routes' . DS,
		'prefix' => ''
	));