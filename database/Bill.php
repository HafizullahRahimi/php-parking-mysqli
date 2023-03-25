<?php

require_once 'config.php';
require_once 'Connection.php';

class Bill extends Connection
{
    // properties



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
    public function setBillSession($userId)
    {
        // Create a Now connection
        $conn = $this->openConn();

        $stmt = $conn->prepare("SELECT bills.user_id, bills.reg_number, bills.vehicle_type, bills.number_plate, parking.place, parking.part, bills.arrival_date FROM bills  INNER JOIN  parking On bills.reg_number = parking.reg_number WHERE bills.user_id = ?;");
        $stmt->bind_param("i", $userId);

        //execute
        $stmt->execute();
        $result = $stmt->get_result();

        // Set SESSION
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $_SESSION["regNum"] = $row['reg_number'];
                $_SESSION["vehicleType"] = $row['vehicle_type'];
                $_SESSION["numPlate"] = $row['number_plate'];
                $_SESSION["place"] = $row['place'];
                if ($row['vehicle_type'] == 2){
                    $_SESSION["part"] =  $row['part'];
                    // $_SESSION["partId"] = $partId;
                } 
                $_SESSION["arrivalDate"] = $row['arrival_date'];
            }
        }

        // Close Conn
        $conn->close();
    }

    // Getter ---------------------------------------------


    // Methods ---------------------------------------------
    public function addBill($regNum, $vehicleType, $numPlate, $userId)
    {
        // Create connection
        $conn = $this->openConn();

        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO `bills` (`reg_number`, `vehicle_type`, `number_plate`, `user_id`, `arrival_date`, `departure_date`) 
        VALUES (?, ?, ?, ?, current_timestamp(), NULL);");

        //set parameters
        $stmt->bind_param("sisi", $regNum, $vehicleType, $numPlate, $userId);
        // execute
        $inserted = $stmt->execute();

        $conn->close();
        return $inserted;
    }
}
