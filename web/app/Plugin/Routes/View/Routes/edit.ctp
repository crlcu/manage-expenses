<div class="span12">
    <?=$this->Form->create('Route', array('class' => 'form-horizontal'));?>        
        <?=$this->Form->input('id');?>
        <?=$this->Form->input('user_id', array('type' => 'hidden', 'value' => $var['User']['id']));?>
        <?php if ( isset($redirect) ):?>
            saved
        <?php endif?>

        <div class="control-group">
            <label class="control-label"><?=__('Url')?></label>
            <?=$this->Form->input('url', array('escape' => false, 'div' => array('class' => 'controls'), 'label' => false, 'class' => 'span3', 'placeholder' => __('URL')));?>
        </div>
        <div class="control-group">
            <label class="control-label"><?=__('Plugin')?></label>
            <?=$this->Form->input('plugin', array('escape' => false, 'div' => array('class' => 'controls'), 'label' => false, 'class' => 'span3', 'placeholder' => __('Plugin')));?>
        </div>
        <div class="control-group">
            <label class="control-label"><?=__('Controller')?></label>
            <?=$this->Form->input('controller', array('escape' => false, 'div' => array('class' => 'controls'), 'label' => false, 'class' => 'span3', 'placeholder' => __('Controller')));?>
        </div>
        <div class="control-group">
            <label class="control-label"><?=__('Action')?></label>
            <?=$this->Form->input('action', array('escape' => false, 'div' => array('class' => 'controls'), 'label' => false, 'class' => 'span3', 'placeholder' => __('Action')));?>
        </div>
    <?=$this->Form->end();?>
</div>