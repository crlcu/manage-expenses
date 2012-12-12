<legend><?=__('Add %s category', $type)?></legend>

<?=$this->Form->create('Category', array('class' => 'well clearfix'));?>
	<div class="span12">
		<?=$this->Form->input('name', array('escape' => false, 'label' => array('text' => __('Name'), 'class' => 'span3'), 'class' => 'span9', 'autofocus' => 'autofocus', 'placeholder' => __('Name')));?>
		<?=$this->Form->input('parent_id', array('escape' => false, 'label' => array('text' => __('Parent category'), 'class' => 'span3'), 'type' => 'select', 'class' => 'span9', 'options' => $parent_categories, 'empty' => ucfirst(__($type))));?> 
		<?=$this->Form->input('order', array('escape' => false, 'label' => array('text' => __('Order'), 'class' => 'span3'), 'class' => 'span9', 'default' => 0));?>
	</div>
<?=$this->Form->end(array('div' => array('class' => 'span12 text-align-right last'), 'label' => __('Add'), 'class' => 'btn btn-success'));?>