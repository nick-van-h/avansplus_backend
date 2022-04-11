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

    function Auth()
    {
        return $this->auth;
    }

    function Db()
    {
        return $this->db;
    }

    function get_message_board()
    {
        if ($this->auth->user_is_guest()) {
            $this->db->get_messages(1);
        } else {
            $this->db->get_messages();
        }
    }
}
