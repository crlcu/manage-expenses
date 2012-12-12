<div class="thumbnail forgot-password-wrapper clearfix">	
     <?php echo $this->Form->create('User', array('class' => 'form-horizontal')); ?>
		<legend class=""><?=__('Recover password')?></legend>
		<?php echo $this->Session->flash(); ?>
		
        <?php echo $this->Form->input('email', array('escape' => false, 'div' => array('class' => 'control-group'), 'label' => __('E-mail'), 'class' => 'span12', 'placeholder' => __('E-mail')))?>
    <?php echo $this->Form->end(array('label' => __('Send e-mail'), 'escape' => false, 'div' => array('class' => 'submit control-group'), 'class' => 'btn btn-success',
		'after' => ' ' . __('or') . ' ' . $this->Html->link(__('Login'), array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'), array('escape' => false, 'title' => __('Login'))) )); ?>
</div>