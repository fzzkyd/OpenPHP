<?php
/**
 * Template class
 */
class Template
{
    private $adaptor;

    /**
     * Constructor
     *
     * @param   string      $adaptor
     */
      public function __construct($adaptor)
      {
        $class = 'Template\\' . $adaptor;

        if (class_exists($class)) {
            $this->adaptor = new $class();
        } else {
            throw new \Exception('Error: Could not load template adaptor ' . $adaptor . '!');
        }
    }

    /**
     * set
     *
     * @param   string      $key
     * @param   mixed       $value
     */
    public function set($key, $value)
    {
        $this->adaptor->set($key, $value);
    }

    /**
     * render
     *
     * @param   string      $template
     * @param   bool        $cache
     *
     * @return  string
     */
    public function render($template, $cache = false)
    {
        return $this->adaptor->render($template, $cache);
    }
}
