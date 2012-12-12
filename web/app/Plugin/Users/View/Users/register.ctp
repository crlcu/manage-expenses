<div class="thumbnail register-wrapper clearfix">	
     <?php echo $this->Form->create('User', array('class' => 'register form-horizontal')); ?>       
		<legend class="">
		  <?=__('Register')?>
		  
		  <?=$this->Html->link('<i class="icon-facebook-sign"></i>', array('plugin' => 'users', 'controller' => 'users', 'action' => 'login', 'facebook'),
				array('escape' => false, 'class' => 'pull-right', 'title' => __('Register with Facebook'), 'onclick' => 'return login.facebook( this.href );'))?>
		</legend>
		<?php echo $this->Session->flash(); ?>
		
        <?=$this->Form->input('UserDetail.first_name', array('escape' => false, 'div' => array('class' => 'control-group'), 'label' => array('text' => __('First name'), 'class' => 'span4'), 'class' => 'span8', 'placeholder' => __('First name')));?>
        <?=$this->Form->input('UserDetail.last_name', array('escape' => false, 'div' => array('class' => 'control-group'), 'label' => array('text' => __('Last name'), 'class' => 'span4'), 'class' => 'span8', 'placeholder' => __('Last name')));?>
        <?=$this->Form->input('UserDetail.gender', array('escape' => false, 'div' => array('class' => 'control-group'), 'label' => array('text' => __('Gender'), 'class' => 'span4'), 'class' => 'span8', 'options' => array('male' => __('male'), 'female' => __('female')), 'empty' => array('' => __('Gender')), 'placeholder' => __('Gender')));?>
        <?=$this->Form->input('UserDetail.phone', array('escape' => false, 'div' => array('class' => 'control-group'), 'label' => array('text' => __('Phone'), 'class' => 'span4'), 'class' => 'span8', 'placeholder' => __('Phone')));?>
        
        <?=$this->Form->input('email', array('escape' => false, 'div' => array('class' => 'control-group'), 'label' => array('text' => __('E-mail'), 'class' => 'span4'), 'class' => 'span8', 'placeholder' => __('E-mail')));?>
        <?=$this->Form->input('username', array('escape' => false, 'div' => array('class' => 'control-group'), 'label' => array('text' => __('Username'), 'class' => 'span4'), 'class' => 'span8', 'placeholder' => __('Username')));?>
        <?=$this->Form->input('passwd', array('escape' => false, 'div' => array('class' => 'control-group'), 'label' => array('text' => __('Password'), 'class' => 'span4'), 'class' => 'span8', 'placeholder' => __('Password')));?>
        <?=$this->Form->input('cpasswd', array('escape' => false, 'div' => array('class' => 'control-group'), 'label' => array('text' => __('Confirm password'), 'class' => 'span4'), 'type' => 'password', 'class' => 'span8', 'placeholder' => __('Confirm password')));?>

     <?php echo $this->Form->end(array('label' => __('Register'), 'div' => array('class' => 'submit control-group'), 'class' => 'btn btn-success',
		'after' => ' ' . __('or') . ' ' . $this->Html->link(__('Login'), array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'), array('escape' => false, 'title' => __('Login'))))); ?>
</div>

<?php
$js = <<<EOF
	$(document).ready(function(){
		login = new Login();
	});
EOF;

	echo $this->Html->scriptBlock($js, array('block' => 'customScript'));
?>
