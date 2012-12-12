<?=$this->Session->flash(); ?>

<?=$this->Form->create('User', array('class' => 'account form-horizontal')); ?>       
	<legend>
		<?php if(!$this->Session->check('Authorization.FacebookChangePass')):?>
			<?=__('Change password')?>
		<?php else:?>
			<?=__('Set password')?>
		<?php endif?>
		
        <?=$this->Form->button('<i class="icon-edit"></i> ' . __('Change'), array('type' => 'submit', 'class' => 'btn btn-success pull-right', 'title' => __('Modify')))?>
    </legend>
	
    <?=$this->Form->input('id')?>
	
	<?php if(!$this->Session->check('Authorization.FacebookChangePass')):?>
		<?=$this->Form->input('oldpasswd', array('escape' => false, 'div' => array('class' => 'control-group'), 'label' => array('text' => __('Old password'), 'class' => 'span3'), 'type' => 'password', 'class' => 'span6', 'placeholder' => __('Old password')));?>
    <?php endif?>
	<?=$this->Form->input('passwd', array('escape' => false, 'div' => array('class' => 'control-group'), 'label' => array('text' => __('New password'), 'class' => 'span3'), 'class' => 'span6', 'placeholder' => __('New password')));?>
    <?=$this->Form->input('cpasswd', array('escape' => false, 'div' => array('class' => 'control-group'), 'label' => array('text' => __('Confirm password'), 'class' => 'span3'), 'type' => 'password', 'class' => 'span6', 'placeholder' => __('Confirm password')));?>
        
 <?=$this->Form->end()?>