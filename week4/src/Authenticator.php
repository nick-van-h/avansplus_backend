<?php

class Authenticator
{
    private const STATUS_NOTLOGGEDIN = 0;
    private const STATUS_LOGGEDIN = self::STATUS_NOTLOGGEDIN + 1;

    private const ROLE_GUEST = 0;
    private const ROLE_USER = self::ROLE_GUEST + 1;
    private const ROLE_ADMIN = self::ROLE_USER  + 1;

    private $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    function user_is_logged_in()
    {
        return $_SESSION['loginstatus'] == self::STATUS_LOGGEDIN;
    }

    function user_is_admin()
    {
        return $this->user_is_logged_in() && $_SESSION['userrole'] == self::ROLE_ADMIN;
    }

    function user_is_user()
    {
        return $this->user_is_logged_in() && $_SESSION['userrole'] == self::ROLE_USER;
    }

    function user_is_guest()
    {
        return $this->user_is_logged_in() && $_SESSION['userrole'] == self::ROLE_GUEST;
    }

    function login_user($username, $password)
    {
        if ($this->db->verify_credentials($username, $password)) {
            $this->set_login_status($this->db->get_user_role($username));
            $_SESSION['user'] = $username;
        } else {
            $_SESSION['message'] .= 'Invalid username and/or password<br>';
        }
    }

    function get_username()
    {
        return $_SESSION['user'];
    }

    function logout()
    {
        $_SESSION['loginstatus'] = self::STATUS_NOTLOGGEDIN;
        $_SESSION['user'] = "";
        session_destroy();
    }

    private function set_login_status($role)
    {
        $_SESSION['loginstatus'] = self::STATUS_LOGGEDIN;
        switch ($role) {
            case 'admin':
                $_SESSION['userrole'] = self::ROLE_ADMIN;
                break;

            case 'user':
                $_SESSION['userrole'] = self::ROLE_USER;
                break;

            case 'guest':
                $_SESSION['userrole'] = self::ROLE_GUEST;
                break;
            default:
                $_SESSION['loginstatus'] = self::STATUS_NOTLOGGEDIN;
                break;
        }
    }
}
