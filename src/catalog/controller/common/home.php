<?php
class ControllerCommonHome extends Controller {
	public function index() {
        $data = array();
        
		$this->response->setOutput($this->load->view('common/home', $data));
	}
}
