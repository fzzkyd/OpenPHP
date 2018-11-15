<?php
class ControllerStartupStartup extends Controller
{
    public function index()
    {
        $this->config->set('config_url', HTTP_SERVER);
        $this->config->set('config_ssl', HTTPS_SERVER);

        // Url
        $this->registry->set('url', new Url($this->config->get('config_url'), $this->config->get('config_ssl')));
    }
}
