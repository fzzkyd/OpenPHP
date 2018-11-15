<?php
/**
 * @package         OpenPHP
 * @author          Shi
 * @license         GPL-3.0
 * @deprecated      The OpenPHP framework was extracted from OpenCart and made some
 *                  adjustments, thanks to the OpenCart development team.
 */

namespace Session;

/**
 * Session DB
 *
 * This library relies on this framework and is not independent
 */
final class DB
{
    public $expire = '';

    /**
     * Construtor
     *
     * @param   object      $registry
     */
    public function __construct($registry)
    {
        $this->db = $registry->get('db');

        $this->expire = ini_get('session.gc_maxlifetime');
    }

    /**
     * read
     *
     * @param   string      $session_id
     *
     * @return  bool
     */
    public function read($session_id)
    {
        $query = $this->db->query("SELECT `data` FROM `" . DB_PREFIX . "session` WHERE session_id = '" . $this->db->escape($session_id) . "' AND expire > " . (int)time());

        if ($query->num_rows) {
            return json_decode($query->row['data'], true);
        } else {
            return false;
        }
    }

    /**
     * write
     *
     * @param	string		$session_id
     * @param	mixed		$data
     *
     * @return	bool
     */
    public function write($session_id, $data)
    {
        if ($session_id) {
            $this->db->query("REPLACE INTO `" . DB_PREFIX . "session` SET session_id = '" . $this->db->escape($session_id) . "', `data` = '" . $this->db->escape(json_encode($data)) . "', expire = '" . $this->db->escape(date('Y-m-d H:i:s', time() + $this->expire)) . "'");
        }

        return true;
    }

    /**
     * destroy
     *
     * @param	string		$session_id
     *
     * @return	bool
     */
    public function destroy($session_id)
    {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "session` WHERE session_id = '" . $this->db->escape($session_id) . "'");

        return true;
    }

    /**
     * gc
     *
     * @param   int         $expire
     *
     * @return  bool
     */
    public function gc($expire)
    {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "session` WHERE expire < " . ((int)time() + $expire));

        return true;
    }
}

/*

CREATE TABLE IF NOT EXISTS `session` (
  `session_id` varchar(32) NOT NULL,
  `data` text NOT NULL,
  `expire` datetime NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

*/