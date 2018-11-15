<?php
namespace Cache;

class Mem
{
    private $expire;
    private $memcache;

    const CACHEDUMP_LIMIT = 9999;

    /**
     * Constructor
     *
     * @param	int			$expire
     */
    public function __construct($expire)
    {
        $this->expire = $expire;

        $this->memcache = new \Memcache();
        $this->memcache->pconnect(CACHE_HOSTNAME, CACHE_PORT);
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
        return $this->memcache->get(CACHE_PREFIX . $key);
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
        return $this->memcache->set(CACHE_PREFIX . $key, $value, MEMCACHE_COMPRESSED, $this->expire);
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
        return $this->memcache->delete(CACHE_PREFIX . $key);
    }
}
