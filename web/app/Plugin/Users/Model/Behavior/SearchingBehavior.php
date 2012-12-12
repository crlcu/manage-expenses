<?php
App::uses('Sanitize', 'Utility');

class SearchingBehavior extends ModelBehavior {

	var $_searchValues = array();
	var $mapMethods = array('/setSearchValues/' => '_setSearchValues');

	function setup(&$Model, $settings = array()) {
		foreach ($settings as $key => $value) {
			if (!is_array($value)) {
				$key = $value;
				$value = array();
			}
			$this->settings[$Model->alias][$key] = array_merge(array('type' => 'text','condition' => 'like','selectOptions' => array()),$value);
		}
		$this->_searchValues[$Model->alias] = array();
	}

	function beforeFind(&$Model, $query) {
		if (isset($query['nosearch']) && $query['nosearch'] === true) {
			return $query;
		}
		if (method_exists($Model, 'beforeDataSearch')) {
			$callbackOptions['values'] = $this->_searchValues[$Model->alias];
			$callbackOptions['settings'] = $this->settings[$Model->alias];

			if (!$Model->beforeDataSearch($query, $callbackOptions)) {
				return $query;
			}
		}
		if (!isset($this->settings[$Model->alias])) {
			return $query;
		}
		$settings = $this->settings[$Model->alias];
		$values = $this->_searchValues[$Model->alias];
		if (isset($_POST['data']['search_clear']) && $_POST['data']['search_clear']==1) {
			return $query;
		}
		foreach ($settings as $field => $options) {
			$fieldModelName = $Model->alias;
			$fieldName = $field;
			if (strpos($field, '.') !== false) {
				list($fieldModelName, $fieldName) = explode('.', $field);
			}
			if (!isset($values[$fieldModelName][$fieldName]) && isset($options['default'])) {
				$values[$fieldModelName][$fieldName] = $options['default'];
			}
			if (!isset($values[$fieldModelName][$fieldName]) || is_null($values[$fieldModelName][$fieldName])) {
				// no value to search with, just skip this field
				continue;
			}
			$searchByField = $fieldName;
			$searchByModel = $fieldModelName;
			if (isset($options['searchField'])) {
				if (strpos($options['searchField'], '.') !== false) {
					list($tmpFieldModel, $tmpFieldName) = explode('.', $options['searchField']);
					$searchByField = $tmpFieldName;
				} else {
					$searchByField = $options['searchField'];
				}
			}
			$realSearchField = sprintf('%s.%s', $searchByModel, $searchByField);
			// TODO: handle NULLs?
			switch ($options['type']) {
				case 'text':
					if (strlen(trim(strval($values[$fieldModelName][$fieldName]))) == 0) {
						continue;
					}
					switch ($options['condition']) {
						case 'like':
						case 'contains':
							$query['conditions'][$realSearchField.' like'] = '%'.$values[$fieldModelName][$fieldName].'%';
							break;
						case 'startswith':
							$query['conditions'][$realSearchField.' like'] = $values[$fieldModelName][$fieldName].'%';
							break;
						case 'endswith':
							$query['conditions'][$realSearchField.' like'] = '%'.$values[$fieldModelName][$fieldName];
							break;
						case '=':
							$query['conditions'][$realSearchField] = $values[$fieldModelName][$fieldName];
							break;
						case 'comma':
							$query['conditions']['OR']=array(array($realSearchField=>$values[$fieldModelName][$fieldName]),array($realSearchField.' like'=>$values[$fieldModelName][$fieldName].',%'),array($realSearchField.' like'=>'%,'.$values[$fieldModelName][$fieldName].',%'),array($realSearchField.' like'=>'%,'.$values[$fieldModelName][$fieldName]));
							break;
						default:
							$query['conditions'][$realSearchField.' '.$options['condition']] = $values[$fieldModelName][$fieldName];
							break;
					}
					break;
				case 'select':
					if (strlen(trim(strval($values[$fieldModelName][$fieldName]))) == 0) {
						continue;
					}
					switch ($options['condition']) {
						case 'comma':
							$query['conditions']['OR']=array(array($realSearchField=>$values[$fieldModelName][$fieldName]),array($realSearchField.' like'=>$values[$fieldModelName][$fieldName].',%'),array($realSearchField.' like'=>'%,'.$values[$fieldModelName][$fieldName].',%'),array($realSearchField.' like'=>'%,'.$values[$fieldModelName][$fieldName]));
							break;
						default:
							$query['conditions'][$realSearchField] = $values[$fieldModelName][$fieldName];
							break;
					}
					break;
				case 'checkbox':
					$query['conditions'][$realSearchField] = $values[$fieldModelName][$fieldName];
					break;
			}
		}
		if (method_exists($Model, 'afterDataSearch')) {
			$callbackOptions['values'] = $this->_searchValues[$Model->alias];
			$callbackOptions['settings'] = $this->settings[$Model->alias];
			$result = $Model->afterDataSearch($query, $callbackOptions);
			if (is_array($result)) {
				$query = $result;
			}
		}
		return $query;
	}

	function _setSearchValues(&$Model, $method, $values = array()) {
		$values = Sanitize::clean($values, array(
											'connection' => $Model->useDbConfig,
											'odd_spaces' => false,
											'encode' => false,
											'dollar' => false,
											'carriage' => false,
											'unicode' => false,
											'escape' => true,
											'backslash' => false
										)
							);
		$this->_searchValues[$Model->alias] = array_merge($this->_searchValues[$Model->alias], $values);
	}
}