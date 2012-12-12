<?=$this->Session->flash(); ?>

<?=$this->Form->create('User', array('class' => 'account form-horizontal')); ?>       
	<legend><?=__('Account details')?>
        <?=$this->Form->button('<i class="icon-edit"></i> ' . __('Modify'), array('type' => 'submit', 'class' => 'btn btn-success pull-right', 'title' => __('Modify')))?>
    </legend>
	
    <?=$this->Form->input('id')?>
    <?=$this->Form->input('UserDetail.id')?>
    
    <?=$this->Form->input('UserDetail.first_name', array('escape' => false, 'div' => array('class' => 'control-group'), 'label' => array('text' => __('First name'), 'class' => 'span3'), 'class' => 'span6', 'placeholder' => __('First name')));?>
    <?=$this->Form->input('UserDetail.last_name', array('escape' => false, 'div' => array('class' => 'control-group'), 'label' => array('text' => __('Last name'), 'class' => 'span3'), 'class' => 'span6', 'placeholder' => __('Last name')));?>
    <?=$this->Form->input('UserDetail.phone', array('escape' => false, 'div' => array('class' => 'control-group'), 'label' => array('text' => __('Phone'), 'class' => 'span3'), 'class' => 'span6', 'placeholder' => __('Phone')));?>
	
    <?=$this->Form->input('email', array('escape' => false, 'div' => array('class' => 'control-group'), 'label' => array('text' => __('Email'), 'class' => 'span3'), 'class' => 'span6', 'placeholder' => __('Email')));?>
    <?=$this->Form->input('username', array('escape' => false, 'div' => array('class' => 'control-group'), 'label' => array('text' => __('Username'), 'class' => 'span3'), 'class' => 'span6', 'placeholder' => __('Username')));?>
    
    <?=$this->Form->input('UserDetail.language', array('escape' => false, 'div' => array('class' => 'control-group'), 'label' => array('text' => __('Language'), 'class' => 'span3'), 'options' => array('eng' => __('English'), 'ron' => __('Romanian')), 'class' => 'span6'));?>
    
 <?=$this->Form->end()?>