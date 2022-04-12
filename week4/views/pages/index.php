<?php

$ctrl = new Controller;

?>

<h1>Message board</h1>
<?php
/**
 * Display a default 'home' message if the user is not logged in
 * Else load the message board
 */
if (!$ctrl->Auth()->user_is_logged_in()) {
    echo ("<p>Please log in to view the message board<br><br>(For demo purposes: Guest/Guest, User/User and Admin/Admin</p>");
} else {
    if ($ctrl->Auth()->user_is_guest()) {
        echo ("<p>Guests are only eligible to view the latest message</p>");
    }
    echo ("<hr>");
    echo ($ctrl->get_message_board());
}
