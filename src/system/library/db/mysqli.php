<?php
namespace DB;

final class MySQLi
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
        $this->connection = new \mysqli($hostname, $username, $password, $database, $port);

        if ($this->connection->connect_error) {
            throw new \Exception('Error: ' . $this->connection->error . '<br />Error No: ' . $this->connection->errno);
        }

        $this->connection->set_charset("utf8");
        $this->connection->query("SET SQL_MODE = ''");
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
        $query = $this->connection->query($sql);

        if (!$this->connection->errno) {
            if ($query instanceof \mysqli_result) {
                $data = array();

                while ($row = $query->fetch_assoc()) {
                    $data[] = $row;
                }

                $result = new \stdClass();
                $result->num_rows = $query->num_rows;
                $result->row = isset($data[0]) ? $data[0] : array();
                $result->rows = $data;

                $query->close();

                return $result;
            } else {
                return true;
            }
        } else {
            throw new \Exception('Error: ' . $this->connection->error  . '<br />Error No: ' . $this->connection->errno . '<br />' . $sql);
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
        return $this->connection->real_escape_string($value);
    }

    /**
     * countAffected
     *
     * @return	int
     */
    public function countAffected()
    {
        return $this->connection->affected_rows;
    }

    /**
     * getLastId
     *
     * @return	int
     */
    public function getLastId()
    {
        return $this->connection->insert_id;
    }

    /**
     * connected
     *
     * @return	bool
     */
    public function connected()
    {
        return $this->connection->ping();
    }

    /**
     * destruct
     */
    public function __destruct()
    {
        $this->connection->close();
    }
}
