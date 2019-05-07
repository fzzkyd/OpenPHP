<?php
namespace User;

/**
 * Member class
 */
class Member
{
    private $member_id;
    private $firstname;
    private $lastname;
    private $member_group_id;
    private $email;
    private $telephone;

    /**
     * Constructor
     *
     * @param	mixed		$registry
     */
    public function __construct($registry)
    {
        $this->config = $registry->get('config');
        $this->db = $registry->get('db');
        $this->request = $registry->get('request');
        $this->session = $registry->get('session');

        if (isset($this->session->data['member_id'])) {
            $member_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "member WHERE member_id = '" . (int)$this->session->data['member_id'] . "' AND status = '1'");

            if ($member_query->num_rows) {
                $this->member_id = $member_query->row['member_id'];
                $this->firstname = $member_query->row['firstname'];
                $this->lastname = $member_query->row['lastname'];
                $this->member_group_id = $member_query->row['member_group_id'];
                $this->email = $member_query->row['email'];
                $this->telephone = $member_query->row['telephone'];

                $this->db->query("UPDATE " . DB_PREFIX . "member SET language_id = '" . (int)$this->config->get('config_language_id') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE member_id = '" . (int)$this->member_id . "'");

                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "member_ip WHERE member_id = '" . (int)$this->session->data['member_id'] . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

                if (!$query->num_rows) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "member_ip SET member_id = '" . (int)$this->session->data['member_id'] . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', date_added = NOW()");
                }
            } else {
                $this->logout();
            }
        }
    }

    /**
     * Login
     *
     * @param	string		$email
     * @param	string		$password
     * @param	bool		$override = false
     *
     * @return	bool
     */
    public function login($email, $password, $override = false)
    {
        if ($override) {
            $member_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "member WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND status = '1'");
        } else {
            $member_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "member WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1'");
        }

        if ($member_query->num_rows) {
            $this->session->data['member_id'] = $member_query->row['member_id'];

            $this->member_id = $member_query->row['member_id'];
            $this->firstname = $member_query->row['firstname'];
            $this->lastname = $member_query->row['lastname'];
            $this->member_group_id = $member_query->row['member_group_id'];
            $this->email = $member_query->row['email'];
            $this->telephone = $member_query->row['telephone'];

            $this->db->query("UPDATE " . DB_PREFIX . "member SET language_id = '" . (int)$this->config->get('config_language_id') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE member_id = '" . (int)$this->member_id . "'");

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
        unset($this->session->data['member_id']);

        $this->member_id = '';
        $this->firstname = '';
        $this->lastname = '';
        $this->member_group_id = '';
        $this->email = '';
        $this->telephone = '';
    }

    /**
     * Is logged
     *
     * @return	int
     */
    public function isLogged()
    {
        return $this->member_id;
    }

    /**
     * Get member id
     *
     * @return	int
     */
    public function getId()
    {
        return $this->member_id;
    }

    /**
     * Get firstname
     *
     * @return	string
     */
    public function getFirstName()
    {
        return $this->firstname;
    }

    /**
     * Get lastname
     *
     * @return	string
     */
    public function getLastName()
    {
        return $this->lastname;
    }


    /**
     * Get member group id
     *
     * @return	int
     */
    public function getGroupId()
    {
        return $this->member_group_id;
    }

    /**
     * Get email
     *
     * @return	string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get telephone
     *
     * @return	string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }
}

/*

DROP TABLE IF EXISTS `oc_member`;
CREATE TABLE `oc_member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_group_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `fax` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(9) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `safe` tinyint(1) NOT NULL,
  `token` text NOT NULL,
  `code` varchar(40) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `oc_member_activity`;
CREATE TABLE `oc_member_activity` (
  `member_activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `key` varchar(64) NOT NULL,
  `data` text NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`member_activity_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `oc_member_approval`;
CREATE TABLE `oc_member_approval` (
  `member_approval_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `type` varchar(9) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`member_approval_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `oc_member_group`;
CREATE TABLE `oc_member_group` (
  `member_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `approval` int(1) NOT NULL,
  `sort_order` int(3) NOT NULL,
  PRIMARY KEY (`member_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `oc_member_group_description`;
CREATE TABLE `oc_member_group_description` (
  `member_group_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`member_group_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `oc_member_history`;
CREATE TABLE `oc_member_history` (
  `member_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`member_history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `oc_member_login`;
CREATE TABLE `oc_member_login` (
  `member_login_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(96) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `total` int(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`member_login_id`),
  KEY `email` (`email`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `oc_member_ip`;
CREATE TABLE `oc_member_ip` (
  `member_ip_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`member_ip_id`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `oc_member_online`;
CREATE TABLE `oc_member_online` (
  `ip` varchar(40) NOT NULL,
  `member_id` int(11) NOT NULL,
  `url` text NOT NULL,
  `referer` text NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

*/