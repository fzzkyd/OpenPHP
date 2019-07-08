<?php
class ControllerCommonHome extends Controller
{
    public function index()
    {
        $this->response->setOutput($this->load->view('common/home'));
    }
}
