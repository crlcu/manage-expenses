<div class="navbar">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			
			<?=$this->Html->link('<i class="icon-home"></i> ' . __('Manage Expenses'), LOGO_URL, array('escape' => false, 'title' => __('Home'), 'class' => 'brand'));?>
			
			<div class="nav-collapse">				
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