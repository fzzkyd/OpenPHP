<?php
/**
 * @package         OpenPHP
 * @author          Shi
 * @license         GPL-3.0
 * @deprecated      The OpenPHP framework was extracted from OpenCart and made some
 *                  adjustments, thanks to the OpenCart development team.
 */

/**
 * DB class
 */
class DB
{
    private $adaptor;

    /**
     * Constructor
     *
     * @param   string      $adaptor
     * @param   string      $hostname
     * @param   string      $username
     * @param   string      $password
     * @param   string      $database
     * @param   int         $port
     */
    public function __construct($adaptor, $hostname, $username, $password, $database, $port = NULL)
    {
        $class = 'DB\\' . $adaptor;

        if (class_exists($class)) {
            $this->adaptor = new $class($hostname, $username, $password, $database, $port);
        } else {
            throw new \Exception('Error: Could not load database adaptor ' . $adaptor . '!');
        }
    }

    /**
     * Query
     *
     * @param   string      $sql
     *
     * @return  bool|object
     */
    public function query($sql)
    {
        return $this->adaptor->query($sql);
    }

    /**
     * escape
     *
     * @param   string      $value
     *
     * @return  string
     */
    public function escape($value)
    {
        return $this->adaptor->escape($value);
    }

    /**
     * countAffected
     *
     * @return  int
     */
    public function countAffected()
    {
        return $this->adaptor->countAffected();
    }

    /**
     * getLastId
     *
     * @return  int
     */
    public function getLastId()
    {
        return $this->adaptor->getLastId();
    }

    /**
     * connected
     *
     * @return  bool
     */
    public function connected()
    {
        return $this->adaptor->connected();
    }
}