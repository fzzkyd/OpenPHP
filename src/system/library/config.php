<?php
/**
 * @package         OpenPHP
 * @author          Shi
 * @license         GPL-3.0
 * @deprecated      The OpenPHP framework was extracted from OpenCart and made some
 *                  adjustments, thanks to the OpenCart development team.
 */

/**
 * Config class
 */
class Config
{
    private $data = array();

    /**
     * Get
     *
     * @param   string      $key
     *
     * @return  mixed
     */
    public function get($key)
    {
        return (isset($this->data[$key]) ? $this->data[$key] : null);
    }

    /**
     * Set
     *
     * @param   string      $key
     * @param   string      $value
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Has
     *
     * @param   string      $key
     *
     * @return  mixed
     */
    public function has($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * Load
     *
     * @param   string      $filename
     */
    public function load($filename)
    {
        $file = DIR_CONFIG . $filename . '.php';

        if (file_exists($file)) {
            $_ = array();

            require($file);

            $this->data = array_merge($this->data, $_);
        } else {
            trigger_error('Error: Could not load config ' . $filename . '!');
            exit();
        }
    }
}