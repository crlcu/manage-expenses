<?php
App::import('Model', 'Expenses.Category');
App::import('Model', 'Expenses.Payment');

class PaymentComponent extends Component{
	public $components = array('Users.Authorization');
	
	function __construct(ComponentCollection $collection, $settings = array()) {
		parent::__construct($collection, $settings);
        
        $this->key = 'team_' . $this->Authorization->User->Team->id();
        
        if ( !$this->key )
            $this->key = $this->Authorization->User->id();
	}
	
	public function initialize($controller) {
	}

	public function startup(&$controller = null) {
	}
	
	public function categories( $option = 'all' ){
		if ( !$categories = Cache::read('payment_categories_' . $this->key, 'expenses') ){
			$category = new Category();
			
    		$categories = $category->find('all', array(
				'conditions' => array(
					'or' => array(
                        'Category.user_id' => $this->Authorization->User->id(),
                        'Category.team_id' => $this->Authorization->User->Team->id(),
                    ),
					'Category.parent_id' => null,
					'Category.type' => 'payments'
				),
				'order' => 'Category.order'
			));
            
            Cache::write('payment_categories_' . $this->key, $categories, 'expenses');
        }
        
        switch ($option){
            case 'list':
                $list = array();
                
                foreach ($categories as $category){
                    $list[$category['Category']['name']] = array();
                    
                    if ( sizeof($category['ChildCategory']) ){                        
                        foreach ( $category['ChildCategory'] as $cildCategory ){
                            $list[$category['Category']['name']][$cildCategory['id']] = $cildCategory['name'];
                        }
                    } else {
                        $list[$category['Category']['name']][$category['Category']['id']] = '&nbsp;'.$category['Category']['name'];        
                    }
                }
                
                return $list;
                break;
            default:
                return $categories;
        }
	}
	
	public function total(){
		if ( !$total = Cache::read('payments_total_' . $this->key, 'expenses') ){
			$payment = new Payment();
			
    		$total = $payment->find('all', array(
				'fields' => array(
					'sum(value) as total'	
				),
				'conditions' => array(
					'or' => array(
                        'Payment.user_id' => $this->Authorization->User->id(),
                        'Payment.team_id' => $this->Authorization->User->Team->id(),
                    )
				)
			));
            
            Cache::write('payments_total_' . $this->key, $total, 'expenses');
        }
		
		return isset($total[0][0])? round($total[0][0]['total'], 2) : 0;	
	}
}