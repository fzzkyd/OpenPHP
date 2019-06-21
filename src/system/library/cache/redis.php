<?php
namespace Cache;

class Redis
{
    private $expire;
    private $cache;

    /**
     * Constructor
     *
     * @param	int			$expire
     */
    public function __construct($expire)
    {
        $this->expire = $expire;

        $this->cache = new \Redis();
        $this->cache->pconnect(CACHE_HOSTNAME, CACHE_PORT);
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
        $data = $this->cache->get(CACHE_PREFIX . $key);
        return json_decode($data, true);
    }

    /**
     * Set
     *
     * @param	string		$key
     * @param	mixed		$value
     *
     * @return	bool
     */
    public function set($key,$value)
    {
        $status = $this->cache->set(CACHE_PREFIX . $key, json_encode($value));
        if($status){
            $this->cache->setTimeout(CACHE_PREFIX . $key, $this->expire);
        }
        return $status;
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
        return $this->cache->delete(CACHE_PREFIX . $key) ? true : false;
    }
}