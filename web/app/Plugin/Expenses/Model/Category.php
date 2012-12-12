<?php
App::uses('ExpensesAppModel', 'Expenses.Model');

class Category extends ExpensesAppModel {
    public $belongsTo = array(
        'ParentCategory' => array(
            'className' => 'Expenses.Category',
            'foreignKey' => 'parent_id'
        )
    );
    
    public $hasMany = array(  
        'ChildCategory'  => array(  
            'className'  => 'Expenses.Category',
			'dependent'  => true,
            'foreignKey' => 'parent_id',
            'order'      => array('order', 'name')
        )
		/*
		'Payments' => array(
			'className'  => 'Expenses.Payment',
			'dependent'  => true
		),
		'Receivables' => array(
			'className'  => 'Expenses.Receivable',
			'dependent'  => true
		)*/
    );
    
    public $validate = array(
		'name' => array(
			'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter category name!'
            ),
            /*'isUnique' => array(
                'rule' => 'isUnique'
            )*/
		)
	);
}