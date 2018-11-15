<?php
/**
 * @package         OpenPHP
 * @author          Shi
 * @license         GPL-3.0
 * @deprecated      The OpenPHP framework was extracted from OpenCart and made some
 *                  adjustments, thanks to the OpenCart development team.
 */

/**
 * Router class
 */
final class Router
{
    private $registry;
    private $pre_action = array();
    private $error;

    /**
     * Constructor
     *
     * @param	object		$route
     */
    public function __construct($registry)
    {
        $this->registry = $registry;
    }

    /**
     * addPreAction
     *
     * @param	object		$pre_action
     */
    public function addPreAction(Action $pre_action)
    {
        $this->pre_action[] = $pre_action;
    }

    /**
     * dispatch
     *
     * @param	object		$action
     * @param	object		$error
     */
    public function dispatch(Action $action, Action $error)
    {
        $this->error = $error;

        foreach ($this->pre_action as $pre_action) {
            $result = $this->execute($pre_action);

            if ($result instanceof Action) {
                $action = $result;

                break;
            }
        }

        while ($action instanceof Action) {
            $action = $this->execute($action);
        }
    }

    /**
     * execute
     *
     * @param	object		$action
     *
     * @return	object
     */
    private function execute(Action $action)
    {
        $result = $action->execute($this->registry);

        if ($result instanceof Action) {
            return $result;
        }

        if ($result instanceof Exception) {
            $action = $this->error;

            $this->error = null;

            return $action;
        }
    }
}