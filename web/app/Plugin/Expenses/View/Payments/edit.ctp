<legend><?=__('Modify payment')?></legend>

<?=$this->Form->create('Payment', array('class' => 'well clearfix'));?>
	<?=$this->Form->input('id');?>
    <div class="first span4">
		<?=$this->Form->input('date', array('escape' => false, 'label' => array('text' => __('Date'), 'class' => 'span4'), 'type' => 'text', 'class' => 'span8', 'rel' => 'datepicker'));?>
        <?=$this->Form->input('category_id', array('escape' => false, 'label' => array('text' => __('Category'), 'class' => 'span4'), 'type' => 'select', 'class' => 'span8', 'options' => $categories, 'empty' => __('Select category')));?> 
        <?=$this->Form->input('value', array('escape' => false, 'label' => array('text' => __('Value'), 'class' => 'span4'), 'class' => 'span8', 'autofocus' => 'autofocus', 'placeholder' => '0.00'));?>
    </div>
    
	<div class="span8">
        <?=$this->Form->input('description', array('escape' => false, 'label' => __('Description'), 'class' => 'span12', 'rows' => 8, 'placeholder' => __('Description')));?>
    </div>
<?=$this->Form->end(array('div' => array('class' => 'span12 text-align-right last'), 'label' => __('Modify'), 'class' => 'btn btn-success'));?>