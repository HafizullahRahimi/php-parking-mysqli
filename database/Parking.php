<?php

require_once 'config.php';
require_once 'Connection.php';
require_once 'Bill.php';

class Parking extends Bill
{

    //properties


    // Constructor
    function __construct($servername, $username, $password, $dbname)
    {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }


    // Setter ---------------------------------------------
    // Getter ---------------------------------------------
    // Get Parking place and part status in a Array
    public function getParkingInfo()
    {
        // Create connection
        $conn = $this->openConn();

        $sql = "SELECT place,part,reg_number,id FROM parking";
        $result = $conn->query($sql);

        $arr = array();
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                // echo "<br> " ."Place: " . " " . $row["place"] ." - Part: " . " " . $row["part"]. "- RegNumber: " . " " . $row["reg_number"] . "<br>";
                array_push($arr, $row);
            }
        } else {
            echo "0 results";
        }

        $parkingArr = array(array('place', 'part1', 'part2', 'partId1', 'partId2'));
        $place = 1;
        for ($i = 0; $i < count($arr); $i++) {
            if ($arr[$i]["place"] == $place) {

                $row = array($arr[$i]["place"], $arr[$i]["reg_number"], $arr[$i + 1]["reg_number"], $arr[$i]["id"], $arr[$i + 1]["id"]);
                array_push($parkingArr, $row);
                $place++;
            }
        }

        $conn->close();
        return $parkingArr;
    }
    // Get all info about Reg number in a Array
    public function getRegnumInfo($regNum)
    {
        // Create a Now connection
        $conn = $this->openConn();


        // prepare and bind select 
        $stmt = $conn->prepare("SELECT 
        users.email, users.first_name , users.last_name,
        bills.reg_number, bills.vehicle_type , bills.arrival_date,
        parking.place, parking.part 
        FROM ((
            users INNER JOIN bills On users.user_id = bills.user_id)
            INNER JOIN parking ON bills.reg_number = parking.reg_number)
        WHERE bills.reg_number = ?");
        $stmt->bind_param("s", $regNum);

        //execute
        $stmt->execute();
        $result = $stmt->get_result();

        $row = array();
        if ($result->num_rows > 0) {
            // output data of each row
            $row = $result->fetch_assoc();
        } else {
            $row = array();
        }

        // Close Conn
        $conn->close();
        return $row;
    }

    // Methods ---------------------------------------------

    //Park a new Vehicle
    public function parkNewVehicle($vehicleType, $numPlate, $userId)
    {
        // Create connection
        $conn = $this->openConn();

        // Create a new Reg Number
        $regNum = 'R' . rand(100, 900);
        $result = false;
        $place = '';
        $part = '';

        // vehicleType  = Car
        if ($vehicleType == 1) {
            $freeplacesForCar = $this->getFreePlacesForCar();

            // IF have Free plase for Car
            if (count($freeplacesForCar) > 0) {
                $randomPlace = $this->getRandomPlace($freeplacesForCar);
                // Free Place for Car
                $place = $randomPlace[0];
                //Create a new Bill
                $addBill = $this->addBill($regNum, $vehicleType, $numPlate, $userId);
                if ($addBill) {
                    // update Place in Parking Table
                    $stmt = $conn->prepare("UPDATE parking SET reg_number = ? WHERE place = ?;");
                    $stmt->bind_param("si", $regNum, $place);
                    $stmt->execute();
                    $result = true;
                    $stmt->close();
                }
            }
        }

        // vehicleType = MC
        if ($vehicleType == 2) {
            $freeplacesForMC = $this->getFreePlacesForMC();

            // IF have Free plase for Car
            if (count($freeplacesForMC) > 0) {
                $randomPlace = $this->getRandomPlace($freeplacesForMC);
                // Free Place for Car
                $place = $randomPlace[0];
                $part = $randomPlace[1];
                $partId = $randomPlace[2];

                // Create a new Bill
                $addBill = $this->addBill($regNum, $vehicleType, $numPlate, $userId);
                if ($addBill) {
                    // update Part in Parking
                    $stmt = $conn->prepare("UPDATE parking SET reg_number = ? WHERE id = ?;");
                    $stmt->bind_param("si", $regNum, $partId);
                    $stmt->execute();
                    $result = true;
                    $stmt->close();
                }
            }
        }

        // Set SESSION 
        if ($result) {
            $_SESSION["regNum"] = $regNum;
            $_SESSION["numPlate"] = $numPlate;
            $_SESSION["vehicleType"] = $vehicleType;
            $_SESSION["place"] = $place;
            if ($vehicleType == 2) {
                $_SESSION["part"] = $part;
                $_SESSION["partId"] = $partId;
            }

            redirect('app/account/profile.php?parked=1');
        }

        $conn->close();
        return $result;
    }

    // Move a Vehicle
    public function moveVehicle($regNum, $vehicleType, $newPlace)
    {
        // Create connection
        $conn = $this->openConn();

        $result = false;

        // vehicleType: CAr
        if ($vehicleType == 1) {
            // Remove Car Old Place
            $stmt = $conn->prepare("UPDATE parking SET reg_number = null WHERE reg_number = ?;");
            $stmt->bind_param("s", $regNum);
            $stmt->execute();
            $stmt->close();

            // Move Car To New Place
            echo 'MCCCCCCCCCCCCCC';
            $stmt = $conn->prepare("UPDATE parking SET reg_number = ? WHERE place = ?;");
            $stmt->bind_param("si", $regNum, $newPlace);
            $stmt->execute();
            $stmt->close();
            $result = true;
        }

        // vehicleType: MC
        if ($vehicleType == 2) {
            // Remove MC Old Place
            $stmt = $conn->prepare("UPDATE parking SET reg_number = null WHERE reg_number = ?;");
            $stmt->bind_param("s", $regNum);
            $stmt->execute();
            $stmt->close();

            // Move MC To New Place
            echo 'MCCCCCCCCCCCCCC';
            $stmt = $conn->prepare("UPDATE parking SET reg_number = ? WHERE id = ?;");
            $stmt->bind_param("si", $regNum, $newPlace);
            $stmt->execute();
            $stmt->close();

            $result = true;
        }

        if ($result) {
            $conn->close();
            redirect('app/index.php?moved=1');
        }
    }

    //Delivery Of Vehicle
    public function deliveryOfVehicle($regNum)
    {
        // Create connection
        $conn = $this->openConn();

        $result = false;

        // vehicleType: CAr
        // if ($vehicleType == 1) {
            // Remove RegNumber From parking
            $stmt = $conn->prepare("UPDATE parking SET reg_number = null WHERE reg_number = ?;");
            $stmt->bind_param("s", $regNum);
            $stmt->execute();
            $stmt->close();

            // Set departure_date
            $stmt = $conn->prepare("DELETE FROM bills WHERE `reg_number` = ?;");
            $stmt->bind_param("s", $regNum );
            $stmt->execute();
            $stmt->close();
            $result = true;

            echo 'End';
        // }



        if ($result) {
            return $result;
            $conn->close();
        }
    }



    // Helper Methods ---------------------------------------------
    // get Random Place from Arr
    public function getRandomPlace($arr)
    {
        // Use array_rand function to returns random key
        $key = array_rand($arr);

        // Display the random array element
        $randomPlace = $arr[$key];
        // dd($randomPlace);
        return $randomPlace;
    }

    // Array Of Free Places For Car
    public function getFreePlacesForCar()
    {
        $parkingArr = $this->getParkingInfo();
        $freePlaceForCarArr = array();

        for ($i = 1; $i < count($parkingArr); $i++) {
            // dd($parkingArr[$i]);
            if ($parkingArr[$i][1] == null && $parkingArr[$i][2] == null) {
                $inserted = [$parkingArr[$i][0], $parkingArr[$i][3], $parkingArr[$i][4]];
                // dd($inserted);
                // echo'<hr>';

                array_push($freePlaceForCarArr, $inserted);
            }
        }

        return $freePlaceForCarArr;
    }

    // Array Of Free Places For MC
    public function getFreePlacesForMC()
    {
        $parkingArr = $this->getParkingInfo();
        $freePlaceForMCArr = array();

        for ($i = 1; $i < 11; $i++) {
            if ($parkingArr[$i][1] == null) {
                $inserted = [$parkingArr[$i][0], '1', $parkingArr[$i][3]];
                array_push($freePlaceForMCArr, $inserted);
            }
            if ($parkingArr[$i][2] == null) {
                $inserted = [$parkingArr[$i][0], '2', $parkingArr[$i][4]];
                array_push($freePlaceForMCArr, $inserted);
            }
        }
        // dd($freePlaceForMCArr);
        return $freePlaceForMCArr;
    }
}
