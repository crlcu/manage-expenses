<?php	
    // In development mode, caches should expire quickly.
    $duration = '+999 days';
    if (Configure::read('debug') >= 1) {
    	$duration = '+10 seconds';
    }

    Cache::config('settings', array(
		'engine' => 'File',
		'duration'=> $duration,
		'path' => CACHE . 'long' . DS,
		'prefix' => ''
	));