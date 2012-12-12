Welcome <?=$user['UserDetail']['first_name']?>, let's help you get signed in.<br />
You have requested to have your password reset on <?=SITE_NAME?>. Please click the link below to reset your password : 
<?=Router::url( array('plugin' => 'users', 'controller' => 'users', 'action' => 'activatePassword', $user['User']['id'], $key), true);?>

Thanks,<br />
<?=SITE_NAME?>