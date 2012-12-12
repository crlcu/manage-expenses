<div class="span12">
    <?=$this->Form->create('User', array('class' => 'form-horizontal'));?>        
        <?=$this->Form->input('id');?>
        <?=$this->Form->input('UserDetail.id');?>
        <?php if ( isset($redirect) ):?>
            saved
        <?php endif?>

        <div class="control-group">
            <label class="control-label"><?=__('Group')?></label>
            <?=$this->Form->input('user_group_id', array('escape' => false, 'div' => array('class' => 'controls'), 'label' => false, 'options' => $groups, 'class' => 'span3'));?>
        </div>
        <div class="control-group">
            <label class="control-label"><?=__('Email')?></label>
            <?=$this->Form->input('email', array('escape' => false, 'div' => array('class' => 'controls'), 'label' => false, 'class' => 'span3', 'placeholder' => __('Email')));?>
        </div>
        <div class="control-group">
            <label class="control-label"><?=__('Username')?></label>
            <?=$this->Form->input('username', array('escape' => false, 'div' => array('class' => 'controls'), 'label' => false, 'class' => 'span3', 'placeholder' => __('Username')));?>
        </div>
        <div class="control-group">
            <label class="control-label"><?=__('Password')?></label>
            <?=$this->Form->input('passwd', array('escape' => false, 'div' => array('class' => 'controls'), 'label' => false, 'class' => 'span3', 'placeholder' => __('Password')));?>
        </div>
        <div class="control-group">
            <label class="control-label"><?=__('Confirm password')?></label>
            <?=$this->Form->input('cpasswd', array('escape' => false, 'div' => array('class' => 'controls'), 'label' => false, 'class' => 'span3', 'placeholder' => __('Confirm password')));?>
        </div>
        <div class="control-group">
            <label class="control-label"><?=__('Language')?></label>
            <?=$this->Form->input('User.language', array('escape' => false, 'div' => array('class' => 'controls'), 'label' => false, 'options' => array('eng' => 'english', 'fre' => 'french'), 'class' => 'span3'));?>
        </div>
        
        <div class="control-group">
            <label class="control-label"><?=__('First name')?></label>
            <?=$this->Form->input('UserDetail.first_name', array('escape' => false, 'div' => array('class' => 'controls'), 'label' => false, 'class' => 'span3', 'placeholder' => __('First name')));?>
        </div>
        <div class="control-group">
            <label class="control-label"><?=__('Last name')?></label>
            <?=$this->Form->input('UserDetail.last_name', array('escape' => false, 'div' => array('class' => 'controls'), 'label' => false, 'class' => 'span3', 'placeholder' => __('Last name')));?>
        </div>
        <div class="control-group">
            <label class="control-label"><?=__('Gender')?></label>
            <?=$this->Form->input('UserDetail.gender', array('escape' => false, 'div' => array('class' => 'controls'), 'label' => false, 'options' => array('male' => 'male', 'female' => 'female'), 'class' => 'span3'));?>
        </div>
    <?=$this->Form->end();?>
</div>