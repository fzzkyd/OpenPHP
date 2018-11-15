<?php
/**
 * @package         OpenPHP
 * @author          Shi
 * @license         GPL-3.0
 * @deprecated      The OpenPHP framework was extracted from OpenCart and made some
 *                  adjustments, thanks to the OpenCart development team.
 */

/**
 * Cache class
 */
class Cache
{
    private $adaptor;

    /**
     * Constructor
     *
     * @param   string      $adaptor    The type of storage for the cache.
     * @param   int         $expire     Optional parameters
     */
    public function __construct($adaptor, $expire = 3600)
    {
        $class = 'Cache\\' . $adaptor;

        if (class_exists($class))
        {
            $this->adaptor = new $class($expire);
        } else {
            throw new \Exception('Error: Could not load cache adaptor ' . $adaptor . ' cache!');
        }
    }

    /**
     * Gets a cache by key name.
     *
     * @param   string      $key        The cache key name
     *
     * @return  string
     */
    public function get($key)
    {
        return $this->adaptor->get($key);
    }

    /**
     * set
     *
     * @param   string      $key        The cache key
     * @param   string      $value      The cache value
     *
     * @return  bool
     */
    public function set($key, $value)
    {
        return $this->adaptor->set($key, $value);
    }

    /**
     * delete
     *
     * @param   string      $key        The cache key
     *
     * @return  bool|int|void
     */
    public function delete($key)
    {
        return $this->adaptor->delete($key);
    }
}
