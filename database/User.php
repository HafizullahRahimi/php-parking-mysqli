<?php
require_once 'config.php';
require_once '../functions/helpers.php';
require_once 'Connection.php';

class User extends Connection
{
    // DB properties



    // User properties
    public $userID;


    // Constructor
    function __construct($servername, $username, $password, $dbname)
    {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    // Setter ---------------------------------------------
    public function setUserId($email)
    {
        // Create connection
        $conn = $this->openConn();
        // prepare and bind select 
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email); //set parameters and 

        // execute
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                // echo "<br> ID: " . $row["user_id"];
                $this->userID =  $row["user_id"];
            }
        } else {
            $this->userID = -1;
        }
    }
    // Getter ---------------------------------------------


    // Methods ---------------------------------------------
    // Register new User 
    public function register($firstName, $lastName, $email, $password, $gender, $img)
    {
        // Create connection
        $conn = $this->openConn();


        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (`user_id`, `email`, `password`, `first_name`, `last_name`, `gender`, `role`, `image`, `status`, `created_at`, `updated_at`) 
                                            VALUES (NULL, ?, ?, ?, ?, ?, '1', ?, '1', current_timestamp(), NULL);");
        //set parameters
        $stmt->bind_param("ssssis", $email, $password, $firstName, $lastName, $gender, $img);
        // execute
        $inserted = $stmt->execute();


        if ($inserted) {
            $conn->close();
            $this->setUserId($email);
        }

        echo "<br> ID: " . $this->userID;
        // START SESSION
        session_start();

        //Set SESSION
        $_SESSION["userId"] = $this->userID;
        $_SESSION["userName"] = $firstName . ' ' . $lastName;
        $_SESSION["userEmail"] = $email;
        $_SESSION["userPassword"] = $password;
        $_SESSION["userGender"] = $gender;
        $_SESSION["userImg"] = $img;


        redirect('app/account/profile.php?registered=1');
    }

    // login
    public function login($email, $password)
    {
        // Create connection
        $conn = $this->openConn();
        //login Status
        $login = false;

        // prepare and bind
        // $stmt = $conn->prepare("SELECT * FROM users  LEFT JOIN  bills On users.user_id = bills.user_id WHERE users.email = ? AND users.password = ?;");
        $stmt = $conn->prepare("SELECT * FROM users  WHERE users.email = ? AND users.password = ?;");
        //set parameters
        $stmt->bind_param("ss", $email, $password);

        // execute
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                // dd($row);
                $_SESSION["userId"] = $row["user_id"];
                $_SESSION["userEmail"] = $row["email"];
                $_SESSION["userPassword"] = $row["password"];
                $_SESSION["userName"] = $row["first_name"] . ' ' . $row["last_name"];
                $_SESSION["userGender"] = $row["gender"];
                $_SESSION["userRole"] = $row["role"];
                $_SESSION["userImg"] = $row["image"];
            }
            $login = true;
            redirect('app/account/profile.php?signed=1');
        } else {
            $login = false;
        }
        
        $conn->close();
        return $login;

    }
}
