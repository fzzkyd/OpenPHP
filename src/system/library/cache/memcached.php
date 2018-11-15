<?php
namespace Cache;

class Memcached
{
    private $expire;
    private $memcached;

    const CACHEDUMP_LIMIT = 9999;

    /**
     * Constructor
     *
     * @param	int			$expire
     */
    public function __construct($expire)
    {
        $this->expire = $expire;
        $this->memcached = new \Memcached();

        $this->memcached->addServer(CACHE_HOSTNAME, CACHE_PORT);
    }

    /**
     * Get
     *
     * @param	string		$key
     *
     * @return	mixed
     */
    public function get($key)
    {
        return $this->memcached->get(CACHE_PREFIX . $key);
    }

    /**
     * Set
     *
     * @param	string		$key
     * @param	mixed		$value
     *
     * @return	bool
     */
    public function set($key, $value)
    {
        return $this->memcached->set(CACHE_PREFIX . $key, $value, $this->expire);
    }

    /**
     * Delete
     *
     * @param	string		$key
     *
     * @return  bool
     */
    public function delete($key)
    {
        return $this->memcached->delete(CACHE_PREFIX . $key);
    }
}
