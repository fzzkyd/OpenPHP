<?php
namespace DB;

final class MySQL
{
    private $connection;

    /**
     * Constructor
     *
     * @param   string      $hostname
     * @param   string      $username
     * @param   string      $password
     * @param   string      $database
     * @param   int         $port
     */
    public function __construct($hostname, $username, $password, $database, $port = '3306')
    {
        if (!$this->connection = mysql_connect($hostname . ':' . $port, $username, $password)) {
            trigger_error('Error: Could not make a database link using ' . $username . '@' . $hostname);
            exit();
        }

        if (!mysql_select_db($database, $this->connection)) {
            throw new \Exception('Error: Could not connect to database ' . $database);
        }

        mysql_query("SET NAMES 'utf8'", $this->connection);
        mysql_query("SET CHARACTER SET utf8", $this->connection);
        mysql_query("SET CHARACTER_SET_CONNECTION=utf8", $this->connection);
        mysql_query("SET SQL_MODE = ''", $this->connection);
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
        if ($this->connection) {
            $resource = mysql_query($sql, $this->connection);

            if ($resource) {
                if (is_resource($resource)) {
                    $i = 0;

                    $data = array();

                    while ($result = mysql_fetch_assoc($resource)) {
                        $data[$i] = $result;

                        $i++;
                    }

                    mysql_free_result($resource);

                    $query = new \stdClass();
                    $query->row = isset($data[0]) ? $data[0] : array();
                    $query->rows = $data;
                    $query->num_rows = $i;

                    unset($data);

                    return $query;
                } else {
                    return true;
                }
            } else {
                $trace = debug_backtrace();

                throw new \Exception('Error: ' . mysql_error($this->connection) . '<br />Error No: ' . mysql_errno($this->connection) . '<br /> Error in: <b>' . $trace[1]['file'] . '</b> line <b>' . $trace[1]['line'] . '</b><br />' . $sql);
            }
        }
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
        if ($this->connection) {
            return mysql_real_escape_string($value, $this->connection);
        }
    }

    /**
     * countAffected
     *
     * @return	int
     */
    public function countAffected()
    {
        if ($this->connection) {
            return mysql_affected_rows($this->connection);
        }
    }

    /**
     * getLastId
     *
     * @return	int
     */
    public function getLastId()
    {
        if ($this->connection) {
            return mysql_insert_id($this->connection);
        }
    }

    /**
     * isConnected
     *
     * @return	bool
     */
    public function isConnected()
    {
        if ($this->connection) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * destruct
     */
    public function __destruct()
    {
        if ($this->connection) {
            mysql_close($this->connection);
        }
    }
}