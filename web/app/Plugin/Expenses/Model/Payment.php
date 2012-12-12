<?php
App::uses('ExpensesAppModel', 'Expenses.Model');

class Payment extends ExpensesAppModel {
    public $belongsTo = array(
        'ChildCategory'  => array(  
            'className'  => 'Category',  
            'foreignKey' => 'category_id'
        ),
        'ParentCategory' => array( 
            'className' => 'Category', 
            'foreignKey' => false, 
            'conditions' => 'ParentCategory.id = ChildCategory.parent_id'
        )
    );
    
    public $validate = array(
		'category_id' => array(
			'rule' => 'notEmpty'
		),
		'description' => array(
			'rule' => 'notEmpty'
		),
        'value' => array(
			'rule' => 'notEmpty'
		)
	);
}
