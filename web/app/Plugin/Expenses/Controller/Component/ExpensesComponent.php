<?php
class ExpensesComponent extends Component{
	public $components = array('Expenses.Payment', 'Expenses.Receivable');
	
	function __construct(ComponentCollection $collection, $settings = array()) {
		parent::__construct($collection, $settings);
	}
	
	public function initialize($controller) {
	}

	public function startup(&$controller = null) {
	}
}