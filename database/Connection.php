<?php

class Connection
{

    // DB properties
    protected $conn;
    protected $servername;
    protected $username;
    protected $password;
    protected $dbname;

    // Create a now connection
    protected function openConn()
    {
        // Create connection
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }
}
