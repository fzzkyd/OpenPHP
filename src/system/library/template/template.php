<?php
namespace Template;

final class Template
{
    private $data = array();

    /**
     * set
     *
     * @param   string      $key
     * @param   mixed       $value
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * render
     *
     * @param   string      $template
     * @param   bool        $cache
     *
     * @return  string
     */
    public function render($template)
    {
        $file = DIR_TEMPLATE . $template . '.tpl';

        if (is_file($file)) {
            extract($this->data);

            ob_start();

            require($file);

            return ob_get_clean();
        }

        throw new \Exception('Error: Could not load template ' . $file . '!');
        exit();
    }
}
