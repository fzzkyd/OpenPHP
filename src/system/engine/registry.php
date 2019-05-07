<?php
/**
 * Registry class
 */
final class Registry
{
    private $data = array();

    /**
     * get
     *
     * @param	string		$key
     *
     * @return	mixed
     */
    public function get($key)
    {
        return (isset($this->data[$key]) ? $this->data[$key] : null);
    }

    /**
     * set
     *
     * @param	string		$key
     * @param	string		$value
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * has
     *
     * @param	string		$key
     *
     * @return	bool
     */
    public function has($key)
    {
        return isset($this->data[$key]);
    }
}