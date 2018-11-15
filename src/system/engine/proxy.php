<?php
/**
 * @package         OpenPHP
 * @author          Shi
 * @license         GPL-3.0
 * @deprecated      The OpenPHP framework was extracted from OpenCart and made some
 *                  adjustments, thanks to the OpenCart development team.
 */

/**
 * Proxy class
 */
class Proxy
{

    /**
     * get
     *
     * @param	string		$key
     *
     * @return	object
     */
    public function __get($key)
    {
        return $this->{$key};
    }

    /**
     * set
     *
     * @param	string		$key
     * @param	string		$value
     */
    public function __set($key, $value)
    {
        $this->{$key} = $value;
    }

    /**
     * call
     *
     * @param	string		$key
     * @param	array		$args
     *
     * @return	array
     */
    public function __call($key, $args)
    {
        $arg_data = array();

        $args = func_get_args();

        foreach ($args as $arg) {
            if ($arg instanceof Ref) {
                $arg_data[] =& $arg->getRef();
            } else {
                $arg_data[] =& $arg;
            }
        }

        if (isset($this->{$key})) {
            return call_user_func_array($this->{$key}, $arg_data);
        } else {
            $trace = debug_backtrace();

            exit('<b>Notice</b>:  Undefined property: Proxy::' . $key . ' in <b>' . $trace[1]['file'] . '</b> on line <b>' . $trace[1]['line'] . '</b>');
        }
    }
}