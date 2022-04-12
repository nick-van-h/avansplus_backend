<?php

class Controller
{
    private $auth;
    private $db;

    function __construct()
    {
        $this->db = new Database();
        $this->auth = new Authenticator($this->db);
    }

    /**
     * Constructs a specific page
     */
    function view($page, $title)
    {
        require(BASE_PATH . '/views/template/head-start.php');
        echo ('<title>' . $title . '</title>');
        require(BASE_PATH . '/views/template/head-resources.php');
        require(BASE_PATH . '/views/template/head-body-transition.php');
        require(BASE_PATH . '/views/components/menu.php');
        require(BASE_PATH . '/views/pages/' . $page);
        require(BASE_PATH . '/views/template/body-end.php');
    }

    /**
     * Access to the Authenticator class
     */
    function Auth()
    {
        return $this->auth;
    }

    /**
     * Access to the Database class
     */
    function Db()
    {
        return $this->db;
    }

    /**
     * Load the complete message board, based on the user role
     */
    function get_message_board()
    {
        if ($this->auth->user_is_guest()) {
            return $this->db->get_messages(1);
        } else {
            return $this->db->get_messages(0, true);
        }
    }
}
