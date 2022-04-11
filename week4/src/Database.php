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
            if ($stmt->execute()) {
                $stmt->bind_result($result);
                $stmt->fetch();
                return ($result > 0);
            } else {
                $_SESSION['error'] = 'Unable to execute query: ' . $e->getMessage();
                return false;
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            return false;
        }
    }

    /**
     * Creates a new entry for the given user
     * Hashes the password
     * Stores the username, password hash and role in the database
     */
    private function create_new_user($username, $password, $role)
    {
        $pw_hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, password_hash, role) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sss', $username, $pw_hash, $role);
        if ($stmt->execute()) {
            //Insert query successfully executed
            $_SESSION['message'] = "Successfully created new user {$username} with role {$role}";
        } else {
            //Query failed
            $_SESSION['message'] = "Trying to create new database entry for {$username} but failed; " . $stmt->error();
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
            $pw_hash = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE users SET password_hash = ? WHERE username = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $pw_hash, $username);
            if ($stmt->execute()) {
                //Insert query successfully executed
                $_SESSION['message'] .= "Successfully updated password for {$username}<br>";
            } else {
                //Query failed
                $_SESSION['message'] .= "Trying to update password for {$username} but failed; " . $stmt->error() . "<br>";
                $success = false;
            }
        }

        /**
         * Update the role if not blank
         */
        if (!empty($role)) {
            $query = "UPDATE users SET role = ? WHERE username = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $role, $username);
            if ($stmt->execute()) {
                //Insert query successfully executed
                $_SESSION['message'] .= "Successfully updated role for {$username} to {$role}<br>";
            } else {
                //Query failed
                $_SESSION['message'] .= "Trying to update role for {$username} but failed; " . $stmt->error() . "<br>";
                $success = false;
            }
        }
        $stmt->close();
        return $success;
    }

    function get_all_users()
    {
        $query = "SELECT username, role FROM users";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute()) {
            //Query succesful, echo results
            $stmt->bind_result($username, $role);
            while ($stmt->fetch()) {
                echo ("<tr><td>{$username}</td><td>{$role}</td></tr>");
            }
        } else {
            //Query failed
            $_SESSION['message'] .= "Trying to fetch all users but failed; " . $stmt->error() . "<br>";
            $success = false;
        }
    }

    function verify_credentials($username, $password)
    {
        $query = "SELECT password_hash FROM users WHERE username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $username);
        if ($stmt->execute()) {
            //Query succesful, get hash
            $stmt->bind_result($hash);
            $stmt->fetch();
            return password_verify($password, $hash);
        } else {
            //Query failed
            $_SESSION['message'] .= "Unable to fetch password for {$username}; " . $stmt->error() . "<br>";
            return false;
        }
    }

    function get_user_role($username)
    {
        $query = "SELECT role FROM users WHERE username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $username);
        if ($stmt->execute()) {
            //Query succesful, get hash
            $stmt->bind_result($role);
            $stmt->fetch();
            return $role;
        } else {
            //Query failed
            $_SESSION['message'] .= "Unable to fetch role for {$username}; " . $stmt->error() . "<br>";
            return false;
        }
    }

    function create_new_message($username, $title, $message)
    {
        $query = "INSERT INTO messages (username, title, message) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sss', $username, $title, $message);
        if ($stmt->execute()) {
            //Insert query successfully executed
            $_SESSION['message'] = "Successfully posted message {$title}";
        } else {
            //Query failed
            $_SESSION['message'] = "Failed to post message {$title}; " . $stmt->error();
        }
        $stmt->close();
    }

    function get_messages($limit = 0)
    {
        $query = "SELECT username, created, title, message FROM messages ORDER BY created DESC";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute()) {
            //Query succesful, echo results
            $stmt->bind_result($username, $created, $title, $message);
            $cnt = 0;
            while ($stmt->fetch() && ($limit == 0 || $cnt < $limit)) {
                echo ("<div class=\"message\"><h3>{$title}</h3><div class=\"annotation\">Posted by {$username} on {$created}</div><p>{$message}</p></div>");
                $cnt++;
            }
        } else {
            //Query failed
            $_SESSION['message'] .= "Trying to fetch all users but failed; " . $stmt->error() . "<br>";
            $success = false;
        }
    }
}
