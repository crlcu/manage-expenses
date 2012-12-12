<div class="navbar">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			
			<?=$this->Html->link('<i class="icon-home"></i> ' . __('Expenses'), LOGO_URL, array('escape' => false, 'title' => __('Home'), 'class' => 'brand'));?>
			
			<div class="nav-collapse">
				<ul class="nav">
					<li class="dropdown <?=sizeof( array_intersect_assoc(array('plugin' => 'users', 'controller' => 'users'), $this->request->params) ) == 2? 'active' : ''?>">
						<?=$this->Html->link('<i class="icon-user"></i> ' . __('Users') . '<b class="caret"></b>', '#',
							array('escape' => false, 'title' => __('Users'), 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'));?>
						<ul class="dropdown-menu">
                            <li class="nav-header"><?=__('By group');?></li>
                            <li><?=$this->Html->link('<i class="icon-hand-right"></i> ' . __('Users'), array('plugin' => 'users', 'controller' => 'users', 'action' => 'index', USERS_USER_GROUP_ID), array('escape' => false, 'title' => __('View all users')));?></li>
							<li><?=$this->Html->link('<i class="icon-star"></i> ' . __('Admins'), array('plugin' => 'users', 'controller' => 'users', 'action' => 'index', USERS_ADMIN_GROUP_ID), array('escape' => false, 'title' => __('View all admin users')));?></li>
							<li><?=$this->Html->link('<i class="icon-list"></i> ' . __('View all'), array('plugin' => 'users', 'controller' => 'users', 'action' => 'index'), array('escape' => false, 'title' => __('View all users')));?></li>
                            <li class="divider"></li>
							<li><?=$this->Html->link('<i class="icon-eye-open"></i> ' . __('Online'), array('plugin' => 'users', 'controller' => 'users', 'action' => 'online'), array('escape' => false, 'title' => __('View online users')));?></li>
						</ul>
					</li>
					<li class="<?=sizeof( array_intersect_assoc(array('plugin' => 'users', 'controller' => 'user_groups'), $this->request->params) ) == 2? 'active' : ''?>" ><?=$this->Html->link('<i class="icon-th"></i> ' . __('Groups'), array('plugin' => 'users', 'controller' => 'user_groups', 'action' => 'index'), array('escape' => false, 'title' => __('Groups')));?></li>
					<li class="<?=sizeof( array_intersect_assoc(array('plugin' => 'users', 'controller' => 'user_group_permissions'), $this->request->params) ) == 2? 'active' : ''?>"><?=$this->Html->link('<i class="icon-ok"></i> ' . __('Permissions'), array('plugin' => 'users', 'controller' => 'user_group_permissions', 'action' => 'index'), array('escape' => false, 'title' => __('Permissions')));?></li>
				    <li class="<?=sizeof( array_intersect_assoc(array('plugin' => 'settings', 'controller' => 'settings'), $this->request->params) ) == 2? 'active' : ''?>"><?=$this->Html->link('<i class="icon-cog"></i> ' . __('Settings'), array('plugin' => 'settings', 'controller' => 'settings', 'action' => 'index'), array('escape' => false, 'title' => __('Settings')));?></li>
					<li class="<?=sizeof( array_intersect_assoc(array('plugin' => 'routes', 'controller' => 'routes'), $this->request->params) ) == 2? 'active' : ''?>"><?=$this->Html->link('<i class="icon-road"></i> ' . __('Routes'), array('plugin' => 'routes', 'controller' => 'routes', 'action' => 'index'), array('escape' => false, 'title' => __('Routes')));?></li>
				</ul>
				
				<ul class="nav pull-right">					
					<li class="divider-vertical"></li>
					<li class="dropdown">
						<?=$this->Html->link($var['UserDetail']['full_name'] . ' <b class="caret"></b>', '#',
							array('escape' => false, 'title' => __('Users'), 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'));?>
						<ul class="dropdown-menu">
                            <li><?=$this->Html->link('<i class="icon-user"></i> ' . __('Account'), array('plugin' => 'users', 'controller' => 'users', 'action' => 'account'), array('escape' => false, 'title' => __('Account')));?></li>
                            <li><?=$this->Html->link('<i class="icon-pencil"></i> ' . __('Change password'), array('plugin' => 'users', 'controller' => 'users', 'action' => 'changePassword'), array('escape' => false, 'title' => __('Change password')));?></li>
                            <li class="divider"></li>
							<li><?=$this->Html->link('<i class="icon-off"></i> ' . __('Logout'), array('plugin' => 'users', 'controller' => 'users', 'action' => 'logout'), array('escape' => false, 'title' => __('Logout')));?></li>
						</ul>
					</li>
				</ul>
			</div><!-- /.nav-collapse -->
		</div>
	</div><!-- /navbar-inner -->
</div>