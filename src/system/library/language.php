<?php
/**
 * @package         OpenPHP
 * @author          Shi
 * @license         GPL-3.0
 * @deprecated      The OpenPHP framework was extracted from OpenCart and made some
 *                  adjustments, thanks to the OpenCart development team.
 */

/**
 * Language class
 */
class Language
{
    private $default = 'en-gb';
    private $directory;
    public $data = array();

    /**
     * Constructor
     *
     * @param   string      $directory
     */
    public function __construct($directory = '')
    {
        $this->directory = $directory;
    }

    /**
     * get
     *
     * @param   string      $key
     *
     * @return  string
     */
    public function get($key)
    {
        return (isset($this->data[$key]) ? $this->data[$key] : $key);
    }

    /**
     * set
     *
     * @param   string      $key
     * @param   string      $value
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * all
     *
     * @return  array
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * load
     *
     * @param   string    $filename
     * @param   string    $key
     *
     * @return  array
     */
    public function load($filename, $key = '')
    {
        if (!$key) {
            $_ = array();

            $file = DIR_LANGUAGE . $this->default . '/' . $filename . '.php';

            if (is_file($file)) {
                require($file);
            }

            $file = DIR_LANGUAGE . $this->directory . '/' . $filename . '.php';

            if (is_file($file)) {
                require($file);
            }

            $this->data = array_merge($this->data, $_);
        } else {
            // Put the language into a sub key
            $this->data[$key] = new Language($this->directory);
            $this->data[$key]->load($filename);
        }

        return $this->data;
    }
}