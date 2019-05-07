<?php
namespace User;

/**
 * Admin
 */
class Admin
{
    private $admin_id;
    private $admin_group_id;
    private $admin_name;
    private $permission = array();

    /**
     * Constructor
     *
     * @param	mixed		$registry
     */
    public function __construct($registry)
    {
        $this->db = $registry->get('db');
        $this->request = $registry->get('request');
        $this->session = $registry->get('session');

        if (isset($this->session->data['admin_id'])) {
            $admin_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "admin WHERE admin_id = '" . (int)$this->session->data['admin_id'] . "' AND status = '1'");

            if ($admin_query->num_rows) {
                $this->admin_id = $admin_query->row['admin_id'];
                $this->admin_name = $admin_query->row['admin_name'];
                $this->admin_group_id = $admin_query->row['admin_group_id'];

                $this->db->query("UPDATE " . DB_PREFIX . "admin SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE admin_id = '" . (int)$this->session->data['admin_id'] . "'");

                $admin_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "admin_group WHERE admin_group_id = '" . (int)$admin_query->row['admin_group_id'] . "'");

                $permissions = json_decode($admin_group_query->row['permission'], true);

                if (is_array($permissions)) {
                    foreach ($permissions as $key => $value) {
                        $this->permission[$key] = $value;
                    }
                }
            } else {
                $this->logout();
            }
        }
    }

    /**
     * Login
     *
     * @param	string		$admin_name
     * @param	string		$password
     *
     * @return	bool
     */
    public function login($admin_name, $password)
    {
        $admin_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "admin WHERE admin_name = '" . $this->db->escape($admin_name) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1'");

        if ($admin_query->num_rows) {
            $this->session->data['admin_id'] = $admin_query->row['admin_id'];

            $this->admin_id = $admin_query->row['admin_id'];
            $this->admin_name = $admin_query->row['admin_name'];
            $this->admin_group_id = $admin_query->row['admin_group_id'];

            $admin_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "admin_group WHERE admin_group_id = '" . (int)$admin_query->row['admin_group_id'] . "'");

            $permissions = json_decode($admin_group_query->row['permission'], true);

            if (is_array($permissions)) {
                foreach ($permissions as $key => $value) {
                    $this->permission[$key] = $value;
                }
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        unset($this->session->data['admin_id']);

        $this->admin_id = '';
        $this->admin_name = '';
    }

    /**
     * Has permission
     *
     * @param	string		$key
     * @param	string		$value
     *
     * @return	bool
     */
    public function hasPermission($key, $value)
    {
        if (isset($this->permission[$key])) {
            return in_array($value, $this->permission[$key]);
        } else {
            return false;
        }
    }

    /**
     * Is logged
     *
     * @return	int
     */
    public function isLogged()
    {
        return $this->admin_id;
    }

    /**
     * Get member id
     *
     * @return	int
     */
    public function getId()
    {
        return $this->admin_id;
    }

    /**
     * Get admin name
     *
     * @return	string
     */
    public function getAdminName()
    {
        return $this->admin_name;
    }

    /**
     * Get admin group id
     *
     * @return	int
     */
    public function getGroupId()
    {
        return $this->admin_group_id;
    }
}

/*

DROP TABLE IF EXISTS `oc_admin`;
CREATE TABLE `oc_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_group_id` int(11) NOT NULL,
  `admin_name` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(9) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `image` varchar(255) NOT NULL,
  `code` varchar(40) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `oc_admin_group`;
CREATE TABLE `oc_admin_group` (
  `admin_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `permission` text NOT NULL,
  PRIMARY KEY (`admin_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `oc_admin_group`
--

INSERT INTO `oc_admin_group` (`admin_group_id`, `name`, `permission`) VALUES
(1, 'Administrator', '{"access":["admin\\/api","admin\\/admin","admin\\/admin_permission"],"modify":["admin\\/api","admin\\/admin","admin\\/admin_permission"]}'),
(10, 'Demonstration', '');

*/