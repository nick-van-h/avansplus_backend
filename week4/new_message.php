<?php

require_once("src/bootstrap.php");

$ctrl = new Controller;

//Redirect the user back to home if they are not admin (not priveleged for this page)
if (!$ctrl->Auth()->user_is_admin()) {
    header("location: index.php");
    exit;
}

$ctrl->view("create_message.php", "Create new message");
