<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	
	/**
     * search
     * @access public
     * @var $criteria : array('Model' => array('field1' => array('condition' => 'like'), 'field2' => array('condition' => '=')))
     * @return array conditions
     */
    public function search( $criteria = null){
        CakeSession::write('Search', $criteria);
        
        $conditions = array();
        
        foreach ( $this->search as $model => $field ){
            foreach ( $field as $key => $settings ){
                if ( isset( $criteria[$model][$key] ) && $criteria[$model][$key] !== '' ){
                    if ($settings['condition'] == 'like')
                        $conditions[$model.'.'.$key. ' '.$settings['condition']] = '%'.$criteria[$model][$key].'%';
                    elseif ($settings['condition'] == '=' && $criteria[$model][$key] !== '' )
                       $conditions[$model.'.'.$key] = $criteria[$model][$key];
                    elseif ( in_array($settings['condition'], array('>', '>=', '<', '<=', '<>')) && !empty($criteria[$model][$key]) )
                        $conditions[$model.'.'.$key. ' '.$settings['condition']] = $criteria[$model][$key];                    
                        
                }
            }
        }
        
        return $conditions;
    }
}
