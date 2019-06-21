<?php
namespace Cache;

class APC
{
    private $expire;
    private $active = false;

    /**
     * Constructor
     *
     * @param	int			$expire
     */
    public function __construct($expire)
    {
        $this->expire = $expire;
        $this->active = function_exists('apc_cache_info') && ini_get('apc.enabled');
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
        return $this->active ? apc_fetch(CACHE_PREFIX . $key) : false;
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
        return $this->active ? apc_store(CACHE_PREFIX . $key, $value, $this->expire) : false;
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
        if (!$this->active) {
            return false;
        }

        $cache_info = apc_cache_info('user');
        $cache_list = $cache_info['cache_list'];
        foreach ($cache_list as $entry) {
            if (strpos($entry['info'], CACHE_PREFIX . $key) === 0) {
                if (!apcu_delete($entry['info'])) {
                    return false;
                }
            }
        }

        return true;
    }
}
