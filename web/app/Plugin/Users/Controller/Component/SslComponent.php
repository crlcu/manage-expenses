<?php
class SslComponent extends Component {
	public function initialize(&$controller) {
	}
	
	public function __construct(ComponentCollection $collection, $settings = array()) {
		parent::__construct($collection, $settings);
	}
	
	public function startup(&$controller = null) {
	}
	
	public function force(&$controller) {
		if(!$controller->request->is('ssl')) {
			$controller->redirect('https://'.$this->__url());
		}
	}
	
	public function unforce(&$controller) {
		if($controller->request->is('ssl')) {
			$controller->redirect('http://'.$this->__urll());
		}
	}
	
	public function __url() {
		$port = env('SERVER_PORT') == 80 ? '' : ':'.env('SERVER_PORT');
		return env('SERVER_NAME').$port.env('REQUEST_URI');
	}
	
	public function __urll() {
		$port = env('SERVER_PORT') == 443 ? '' : ':'.env('SERVER_PORT');
		return env('SERVER_NAME').$port.env('REQUEST_URI');
	}
}