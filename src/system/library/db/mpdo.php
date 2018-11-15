<?php
namespace DB;

final class mPDO
{
    private $connection = null;
    private $statement = null;

    /**
     * Constructor
     *
     * @param	string		$hostname
     * @param	string		$username
     * @param	string		$password
     * @param	string		$database
     * @param	int			$port
     */
    public function __construct($hostname, $username, $password, $database, $port = '3306')
    {
        try {
            $this->connection = new \PDO("mysql:host=" . $hostname . ";port=" . $port . ";dbname=" . $database, $username, $password, array(\PDO::ATTR_PERSISTENT => true));
        } catch(\PDOException $e) {
            throw new \Exception('Failed to connect to database. Reason: \'' . $e->getMessage() . '\'');
        }

        $this->connection->exec("SET NAMES 'utf8'");
        $this->connection->exec("SET CHARACTER SET utf8");
        $this->connection->exec("SET CHARACTER_SET_CONNECTION=utf8");
        $this->connection->exec("SET SQL_MODE = ''");
    }

    /**
     * Prepare
     *
     * @param	string		$sql
     */
    public function prepare($sql)
    {
        $this->statement = $this->connection->prepare($sql);
    }

    /**
     * bindParam
     *
     * @param	mixed		$parameter
     * @param	mixed		$variable
     * @param	int			$data_type
     * @param	int			$length
     */
    public function bindParam($parameter, $variable, $data_type = \PDO::PARAM_STR, $length = 0)
    {
        if ($length) {
            $this->statement->bindParam($parameter, $variable, $data_type, $length);
        } else {
            $this->statement->bindParam($parameter, $variable, $data_type);
        }
    }

    /**
     * execute
     */
    public function execute()
    {
        try {
            if ($this->statement && $this->statement->execute()) {
                $data = array();

                while ($row = $this->statement->fetch(\PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }

                $result = new \stdClass();
                $result->row = (isset($data[0])) ? $data[0] : array();
                $result->rows = $data;
                $result->num_rows = $this->statement->rowCount();
            }
        } catch(\PDOException $e) {
            throw new \Exception('Error: ' . $e->getMessage() . ' Error Code : ' . $e->getCode());
        }
    }

    /**
     * Query
     *
     * @param   string      $sql
     * @param   array		$params
     *
     * @return  bool|object
     */
    public function query($sql, $params = array())
    {
        $this->statement = $this->connection->prepare($sql);

        $result = false;

        try {
            if ($this->statement && $this->statement->execute($params)) {
                $data = array();

                while ($row = $this->statement->fetch(\PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }

                $result = new \stdClass();
                $result->row = (isset($data[0]) ? $data[0] : array());
                $result->rows = $data;
                $result->num_rows = $this->statement->rowCount();
            }
        } catch (\PDOException $e) {
            throw new \Exception('Error: ' . $e->getMessage() . ' Error Code : ' . $e->getCode() . ' <br />' . $sql);
        }

        if ($result) {
            return $result;
        } else {
            $result = new \stdClass();
            $result->row = array();
            $result->rows = array();
            $result->num_rows = 0;
            return $result;
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
        return str_replace(array("\\", "\0", "\n", "\r", "\x1a", "'", '"'), array("\\\\", "\\0", "\\n", "\\r", "\Z", "\'", '\"'), $value);
    }

    /**
     * countAffected
     *
     * @return	int
     */
    public function countAffected()
    {
        if ($this->statement) {
            return $this->statement->rowCount();
        } else {
            return 0;
        }
    }

    /**
     * getLastId
     *
     * @return	int
     */
    public function getLastId()
    {
        return $this->connection->lastInsertId();
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
        $this->connection = null;
    }
}
