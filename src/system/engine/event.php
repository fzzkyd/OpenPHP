<?php
/**
 * @package         OpenPHP
 * @author          Shi
 * @license         GPL-3.0
 * @deprecated      The OpenPHP framework was extracted from OpenCart and made some
 *                  adjustments, thanks to the OpenCart development team.
 */

/**
 * Event class
 *
 * Event System Userguide
 */
class Event
{
    protected $registry;
    protected $data = array();

    /**
     * Constructor
     *
     * @param   object      $route
     */
    public function __construct($registry)
    {
        $this->registry = $registry;
    }

    /**
     * register
     *
     * @param   string      $trigger
     * @param   object      $action
     * @param   int         $priority
     */
    public function register($trigger, Action $action, $priority = 0)
    {
        $this->data[] = array(
            'trigger'  => $trigger,
            'action'   => $action,
            'priority' => $priority
        );

        $sort_order = array();

        foreach ($this->data as $key => $value) {
            $sort_order[$key] = $value['priority'];
        }

        array_multisort($sort_order, SORT_ASC, $this->data);
    }

    /**
     * trigger
     *
     * @param   string      $event
     * @param   array       $args
     *
     * @return  object|void
     */
    public function trigger($event, array $args = array())
    {
        foreach ($this->data as $value) {
            if (preg_match('/^' . str_replace(array('\*', '\?'), array('.*', '.'), preg_quote($value['trigger'], '/')) . '/', $event)) {
                $result = $value['action']->execute($this->registry, $args);

                if (!is_null($result) && !($result instanceof Exception)) {
                    return $result;
                }
            }
        }
    }

    /**
     * unregister
     *
     * @param   string      $trigger
     * @param   string      $route
     */
    public function unregister($trigger, $route)
    {
        foreach ($this->data as $key => $value) {
            if ($trigger == $value['trigger'] && $value['action']->getId() == $route) {
                unset($this->data[$key]);
            }
        }
    }

    /**
     * clear
     *
     * @param   string      $trigger
     */
    public function clear($trigger)
    {
        foreach ($this->data as $key => $value) {
            if ($trigger == $value['trigger']) {
                unset($this->data[$key]);
            }
        }
    }
}