<div class="span12">
    <?=$this->Form->create('UserGroup', array('class' => 'form-horizontal'));?>
        <?=$this->Form->input('id');?>
        <div class="control-group">
            <label class="control-label"><?=__('Name')?></label>
            <?=$this->Form->input('name', array('escape' => false, 'div' => array('class' => 'controls'), 'label' => false));?>
        </div>
        <div class="control-group">
            <label class="control-label"><?=__('Alias name')?></label>
            <?=$this->Form->input('alias_name', array('escape' => false, 'div' => array('class' => 'controls'), 'label' => false));?>
        </div>
        <div class="control-group">
            <label class="control-label"><?=__('Allow registration')?></label>
            <?=$this->Form->input('allow_registration', array('escape' => false, 'div' => array('class' => 'controls'), 'label' => false, 'options' => array('1' => __('Yes'), '0' => __('No') )));?>
        </div>
    <?=$this->Form->end();?>
</div>