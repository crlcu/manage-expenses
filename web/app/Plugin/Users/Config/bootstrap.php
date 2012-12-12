<?php   
    /**
     * This actions dosen't require authentication
     */
    if ( !defined('PERMISSION_FREE')){
		define('PERMISSION_FREE', serialize(array(
			#'controller/action
			'users/login',
			'users/logout',
			'users/register',
			'users/userVerification',
			'users/forgotPassword',
			'users/activatePassword',
			'users/accessDenied',
			'users/emailVerification'
		)));
	}
    
    /**
     * Util functions
     */
	require dirname(__FILE__) . DS . 'util.php';