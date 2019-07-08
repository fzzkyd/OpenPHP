<?php
class ControllerErrorNotFound extends Controller
{
    public function index()
    {
        $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

        $this->response->setOutput($this->load->view('error/not_found', $data));
    }
}
