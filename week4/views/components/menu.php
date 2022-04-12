<?php

$ctrl = new Controller();

?>

<menu>
    <ul>
        <li>
            <a href="index.php">Home</a>
        </li>
        <?php
        //New message and manage user buttons if the user is an admin
        if ($ctrl->Auth()->user_is_admin()) {
        ?>
            <li>
                <a href="new_message.php">Post new message</a>
            </li>
            <li>
                <a href="manage_users.php">Manage users</a>
            </li>
        <?php
        }
        ?>
        <?php
        //Logout button if the user is logged in
        if ($ctrl->Auth()->user_is_logged_in()) {
        ?>
            <li>
                <a href="logout.php">Logout</a>
            </li>
            <li class="float-right">
                Logged in as: <?php echo ($ctrl->Auth()->get_username()); ?>
            </li>
        <?php
        } else {
        ?>
            <li>
                <a href="login.php">Login</a>
            </li>
        <?php
        }
        ?>
    </ul>
</menu>