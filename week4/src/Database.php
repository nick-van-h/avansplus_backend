<?php

class Database extends DatabaseAbstract
{
    private $db;
    function __construct()
    {
        /**
         * Get the credentials through the DatabaseAbstract
         * The DatabaseAbstract parses the credentials as stored on the server
         * The function get_db_config_file returns an array containing the credentials
         * These credentials can then be used to create a mysqli object which connects to the database
         */
        $conf = $this->get_db_config_file();
        $this->db = new mysqli($conf['host'], $conf['username'], $conf['password'], $conf['database']);

        //Check connection
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    function __destruct()
    {
        if ($db) {
            $db->close();
        }
    }

    /**
     * Creates a new user in the database
     * Returns the result as a status message
     */
    function update_user($username, $password, $role)
    {
        /**
         * If there is an entry for the given user, update that entry
         * Else create a new entry
         */
        if ($this->user_exists($username)) {
            $this->modify_existing_user($username, $password, $role);
        } else {
            $this->create_new_user($username, $password, $role);
        }
    }

    /**
     * Count the number of entries of the given username
     * Returns true if there is at least one entry, or
     * false if there are no entries
     */
    private function user_exists($username)
    {
        try {
            $query = "SELECT COUNT(*) FROM users WHERE username = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->bind_result($result);
            $stmt->fetch();
            return ($result > 0);
        } catch (Exception $e) {
            $_SESSION['message'] .= 'Unable to execute query: ' . $stmt->error() . " - " . $e->getMessage() . "<br>";
            return false;
        }
        $stmt->close();
    }

    /**
     * Creates a new entry for the given user
     * Hashes the password
     * Stores the username, password hash and role in the database
     */
    private function create_new_user($username, $password, $role)
    {
        try {
            $pw_hash = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (username, password_hash, role) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sss', $username, $pw_hash, $role);
            $stmt->execute();
            $_SESSION['message'] .= "Successfully created new user {$username} with role {$role}<br>";
        } catch (Exception $e) {
            //Query failed
            $_SESSION['message'] .= "Trying to create new database entry for {$username} but failed; " . $stmt->error() . " - " . $e->getMessage() . "<br>";
        }
        $stmt->close();
    }

    /**
     * Updates the password and/or role for the given user
     */
    private function modify_existing_user($username, $password, $role)
    {
        $success = true;
        /**
         * Update the password if not blank
         */
        if (!empty($password)) {
            try {
                $pw_hash = password_hash($password, PASSWORD_DEFAULT);
                $query = "UPDATE users SET password_hash = ? WHERE username = ?";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('ss', $pw_hash, $username);
                $stmt->execute();
                $_SESSION['message'] .= "Successfully updated password for {$username}<br>";
            } catch (Exception $e) {
                //Query failed
                $_SESSION['message'] .= "Trying to update password for {$username} but failed; " . $stmt->error() . " - " . $e->getMessage() . "<br>";
                $success = false;
            }
        }

        /**
         * Update the role if not blank
         */
        if (!empty($role)) {
            try {
                $query = "UPDATE users SET role = ? WHERE username = ?";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('ss', $role, $username);
                $stmt->execute();
                $_SESSION['message'] .= "Successfully updated role for {$username} to {$role}<br>";
            } catch (Exception $e) {
                //Query failed
                $_SESSION['message'] .= "Trying to update role for {$username} but failed; " . $stmt->error() . " - " . $e->getMessage() . "<br>";
                $success = false;
            }
        }
        $stmt->close();
        return $success;
    }

    /**
     * Returns a preformatted string of table rows containing all users and their role
     */
    function get_all_users()
    {
        try {
            $query = "SELECT username, role FROM users";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $stmt->bind_result($username, $role);
            $msg = '';
            while ($stmt->fetch()) {
                $msg .= "<tr><td>{$username}</td><td>{$role}</td></tr>";
            }
            return $msg;
        } catch (Exception $e) {
            //Query failed
            $_SESSION['message'] .= "Trying to fetch all users but failed; " . $stmt->error() . " - " . $e->getMessage() . "<br>";
            return false;
        }
    }

    /**
     * Retrieves the password hash from the database for the given user
     * Then verifies if the password and the hash match
     */
    function verify_credentials($username, $password)
    {
        try {
            $query = "SELECT password_hash FROM users WHERE username = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->bind_result($hash);
            $stmt->fetch();
            return password_verify($password, $hash);
        } catch (Exception $e) {
            //Query failed
            $_SESSION['message'] .= "Unable to fetch password for {$username}; " . $stmt->error() . " - " . $e->getMessage() . "<br>";
            return false;
        }
    }

    /**
     * Gets the role from the database for the given user
     */
    function get_user_role($username)
    {
        try {
            $query = "SELECT role FROM users WHERE username = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->bind_result($role);
            $stmt->fetch();
            return $role;
        } catch (Exception $e) {
            //Query failed
            $_SESSION['message'] .= "Unable to fetch role for {$username}; " . $stmt->error() . " - " . $e->getMessage() . "<br>";
            return false;
        }
    }

    /**
     * Creates a new message entry
     */
    function create_new_message($username, $title, $message)
    {
        try {
            $query = "INSERT INTO messages (username, title, message) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sss', $username, $title, $message);
            $stmt->execute();
            $_SESSION['message'] = "Successfully posted message {$title}";
        } catch (Exception $e) {
            //Query failed
            $_SESSION['message'] = "Failed to post message {$title}; " . $stmt->error() . " - " . $e->getMessage() . "<br>";
        }
        $stmt->close();
    }

    /**
     * Updates an existing message based on the message ID
     */
    function update_message($username, $id, $title, $message)
    {
        try {
            $query = "UPDATE messages SET title = ?, message = ?, lastupdate = Now(), updateby = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sssi', $title, $message, $username, $id);
            $stmt->execute();
            $_SESSION['message'] = "Successfully updated message {$title}";
        } catch (Exception $e) {
            //Query failed
            $_SESSION['message'] = "Failed to post message {$title}; " . $stmt->error() . " - " . $e->getMessage() . "<br>";
        }
        $stmt->close();
    }

    /**
     * Creates a preformatted string containing all messages
     * Retrieve all messages from the database, order descending by creation date (newest first)
     * Optionally limit the number of messages to be displayed, if limit is 0 there is no limit
     * Optionally display an edit button for the admin
     */
    function get_messages($limit = 0, $admin = false)
    {
        try {
            //Prepare and execute the query
            $query = "SELECT id, username, created, title, message, updateby, lastupdate FROM messages ORDER BY created DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $stmt->bind_result($id, $username, $created, $title, $message, $updateBy, $lastUpdate);

            //Fetch resulting rows and create message
            $cnt = 0;
            $msg = '';
            while ($stmt->fetch() && ($limit == 0 || $cnt < $limit)) {
                $msg .= "<div class=\"message\" id=\"message-{$id}\"><h3>{$title}</h3><div class=\"annotation\">Posted by {$username} on {$created}</div>";
                if ($updateBy) {
                    $msg .= "<div class=\"annotation\">Last updated by {$updateBy} on {$lastUpdate}</div>";
                }
                $msg .= "<p>{$message}</p>";
                if ($admin) {
                    $msg .= "<button onclick=\"updateMessage({$id})\">Edit</button>";
                }
                $msg .= "</div>";
                $cnt++;
            }

            return $msg;
        } catch (Exception $e) {
            //Query failed
            $_SESSION['message'] .= "Trying to fetch all users but failed; " . $stmt->error() . " - " . $e->getMessage() . "<br>";
            return false;
        }
    }
}
