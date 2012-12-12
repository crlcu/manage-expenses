<?=$this->Form->create('Chart', array('class' => 'chart alert alert-info clearfix'))?>
	<?=$this->Form->input('from', array('escape' => false, 'div' => array('class' => 'first span2'), 'label' => false, 'rel' => 'datepicker', 'class' => 'daterange from span12', 'placeholder' => __('From being of time')))?>
	<?=$this->Form->input('to', array('escape' => false, 'div' => array('class' => 'span2'), 'label' => false, 'rel' => 'datepicker', 'class' => 'daterange to span12', 'placeholder' => __('To %s', date('Y-m-d'))))?>
	<?=$this->Form->input('type', array('escape' => false, 'div' => array('class' => 'span2'), 'label' => false, 'class' => 'span12', 'options' => array('column' => __('Column'), 'pie' => __('Pie'))))?>
	<?=$this->Form->input('model', array('escape' => false, 'div' => array('class' => 'span2'), 'label' => false, 'class' => 'span12', 'options' => array('Payment' => __('Payments'), 'Receivable' => __('Receivables'))))?>
<?=$this->Form->end(array('div' => array('class' => 'span2 pull-right'), 'label' => __('generate'), 'class' => 'btn btn-success pull-right'))?>


<p align="center"><?=$title?></p>
<div id="chart"></div>	
<?=$this->HighCharts->render('chart'); ?>