<div class="thumbnail login-wrapper clearfix">	
    <?=$this->Form->create('User', array('id' => 'login-form', 'class' => 'form-horizontal')); ?>
        <legend class="">
			<?=__('Login')?>
			
			<?=$this->Html->link('<i class="icon-facebook-sign"></i>', array('plugin' => 'users', 'controller' => 'users', 'action' => 'login', 'facebook'),
				array('escape' => false, 'class' => 'pull-right', 'title' => __('Login with Facebook'), 'onclick' => 'return login.facebook( this.href );'))?>
			
			<!--
			<?=$this->Html->link('<i class="icon-twitter-sign"></i>', array('plugin' => 'users', 'controller' => 'users', 'action' => 'login', 'twitter'),
				array('escape' => false, 'class' => 'pull-right', 'title' => __('Login with Twitter'), 'onclick' => 'return login.facebook( this.href );'))?>
			-->
		</legend>
		<?php echo $this->Session->flash(); ?>
		
		<?=$this->Form->input('email', array('escape' => false, 'div' => array('class' => 'control-group'), 'label' => __('E-mail or Username'), 'class' => 'span12', 'autofocus' => 'autofocus', 'placeholder' => __('E-mail or Username')))?>
        <?=$this->Form->input('password', array('escape' => false, 'div' => array('class' => 'control-group'), 'label' => __('Password'), 'class' => 'span12', 'placeholder' => __('Password')))?>
        
        <div class="control-group">
			<?=$this->Form->input('remember', array('escape' => false, 'div' => array('class' => 'span4 checkbox'), 'label' => array('text' => __('Keep me logged in'), 'title' => __('Tick this if you want to keep you logged in')), 'type' => 'checkbox', 'title' => __('Tick this if you want to keep you logged in')))?>
			<?=$this->Html->link('<i class="icon-question-sign"></i> ' . __('Forgot password?'), array('plugin' => 'users', 'controller' => 'users', 'action' => 'forgotPassword'), array('escape' => false, 'title' => __('Forgot password?'), 'class' => 'pull-right')) ?>
		</div>
		
    <?=$this->Form->end(array('label' => __('Login'), 'escape' => false, 'class' => 'btn btn-success',
		'after' => ' ' . __('or') . ' ' . $this->Html->link(__('Register'), array('plugin' => 'users', 'controller' => 'users', 'action' => 'register'), array('escape' => false, 'title' => __('Register'))) )); ?>
</div>

<?php
$js = <<<EOF
	$(document).ready(function(){
		login = new Login();
	});
EOF;

	echo $this->Html->scriptBlock($js, array('block' => 'customScript'));
?>