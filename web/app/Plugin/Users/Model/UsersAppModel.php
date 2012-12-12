<?php
App::uses('AppModel', 'Model');

class UsersAppModel extends AppModel {

	/**
	 * Used to match passwords
	 *
	 * @access public
	 * @return boolean
	 */
	public function verifies() {
		return ($this->data['User']['password']===$this->data['User']['cpassword']);
	}
	/**
	 * Used to validate string with letter, integer, dash, underscore
	 *
	 * @access public
	 * @return boolean
	 */
	public function alphaNumericDashUnderscore($check) {
		$value = array_values($check);
		$value = $value[0];
		return preg_match('|^[0-9a-zA-Z_-]*$|', $value);
	}
	/**
	 * Used to validate string with letter, integer, dash, underscore, space
	 *
	 * @access public
	 * @return boolean
	 */
	public function alphaNumericDashUnderscoreSpace($check) {
		$value = array_values($check);
		$value = $value[0];
		return preg_match('|^[0-9 a-zA-Z_-]*$|', $value);
	}
	/**
	 * Used to validate string with letter
	 *
	 * @access public
	 * @return boolean
	 */
	public function alpha($check) {
		$value = array_values($check);
		$value = $value[0];
		return preg_match('|[a-zA-Z]|', $value);
	}
	/**
	 * Used to validate cellphone
	 *
	 * @access public
	 * @return boolean
	 */
	public function cellphone($check) {
		$value = array_values($check);
		$value = $value[0];
		return preg_match('|^[0-9-+]*$|', $value);
	}
}