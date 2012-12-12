<div class="span12">
    <?=$this->Form->create('Setting', array('class' => 'form-horizontal'));?>        
        <?=$this->Form->input('id');?>
        <?=$this->Form->input('user_id', array('type' => 'hidden', 'value' => $var['User']['id']));?>
        <?php if ( isset($redirect) ):?>
            saved
        <?php endif?>

        <div class="control-group">
            <label class="control-label"><?=__('Description')?></label>
            <?=$this->Form->input('description', array('escape' => false, 'div' => array('class' => 'controls'), 'label' => false, 'class' => 'span3', 'placeholder' => __('Description')));?>
        </div>
        <?php if ( $this->data['Setting']['type'] == 'boolean' ): ?>
        <div class="control-group">
            <label class="control-label"><?=__('Value')?></label>
            <?=$this->Form->input('value', array('escape' => false, 'div' => array('class' => 'controls'), 'label' => false, 'options' => array('1' => __('Yes'), '0' => __('No')), 'class' => 'span3', 'placeholder' => __('Value')));?>
        </div>
        <?php else: ?>
        <div class="control-group">
            <label class="control-label"><?=__('Value')?></label>
            <?=$this->Form->input('value', array('escape' => false, 'div' => array('class' => 'controls'), 'label' => false, 'class' => 'span3', 'placeholder' => __('Value')));?>
        </div>
        <?php endif ?>
    <?=$this->Form->end();?>
</div>