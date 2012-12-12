Hi <?=$user['UserDetail']['full_name']?>,<br />
Click the link below to confirm your email address : 
<?=$this->Html->link(Router::url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'verification', $user['User']['id'], $key), true),
    Router::url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'verification', $user['User']['id'], $key), true))?>