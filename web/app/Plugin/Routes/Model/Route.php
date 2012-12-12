<?php
App::uses('RouteAppModel', 'Routes.Model');

class Route extends RouteAppModel {
	public $hasMany = array(
		#parameters that appear in function header
		'Params' => array(
			'dependent' => true,
            'className' => 'Routes.RouteParams',
			'conditions' => array(
				'type' => ''
			)
        ),
		#named parameters that appear in function header
		#Ex : id:1
		'NamedParams' => array(
			'dependent' => true,
            'className' => 'Routes.RouteParams',
			'conditions' => array(
				'type' => 'named'
			)
        )
    );
	
	/**
	 * model validation array
	 */
	public $validate = array(
        'url' => array(
			'notEmpty' => array(
                'rule'		=> 'notEmpty',
                'required'	=> true,
                'message' 	=> 'Please enter url!'
            ),
			'isUnique' => array(
                'rule' 		=> 'isUnique',
                'required'	=> true,
				'message'	=> 'Url already exist!'
            )
        ),
		'controller' => array(
			'notEmpty' => array(
                'rule'		=> 'notEmpty',
                'required'	=> true,
                'message' 	=> 'Please enter controller!'
            )
		),
		'action' => array(
			'notEmpty' => array(
                'rule'		=> 'notEmpty',
                'required'	=> true,
                'message' 	=> 'Please enter action!'
            )
		)
	);
    
    /**
	 *	model search conditions
	 */
	public $search = array(
        'Route' => array(
            'url' => array(
                'condition' => 'like'
            ),
            'plugin' => array(
                'condition' => '='
            ),
			'controller' => array(
                'condition' => '='
            ),
			'action' => array(
                'condition' => '='
            )
        )
    );
    
	public function all( $conditions = array(), $options = array() ){
		$options = array_merge(array('conditions' => $conditions), $options);
		
		return $this->find('all', $options);
	}
}