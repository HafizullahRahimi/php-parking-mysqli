<?php
//require Files
require_once '../../functions/helpers.php';
require_once '../../database/Parking.php';

//The Current Page Filename
$current_page_name = basename($_SERVER['PHP_SELF'], 'php');

//Time Zone Sweden
date_default_timezone_set("Europe/Stockholm");
$format = "Y-m-d H:i:s"; //2023/02/07 18:48:54

// START SESSION
session_start();

//-----------------------------------------------------------
// echo  $_SESSION["regNum"];

?>

<!-- POST -->
<?php
$userId = $name = $email = $password = $place =  $regNum = $vehicleType = $checkInTime = $checkOutTime = $time = $bill = "";
$deliveryStatus = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userId = $_SESSION["userId"];
    $name = $_SESSION["userName"];
    $email =  $_SESSION["userEmail"];
    $password = $_SESSION["userPassword"];
    $gender = $_SESSION["userGender"];

    $regNum = $_POST["regNumber"];
    $numPlate = $_SESSION["numPlate"];
    $checkInTime = $_SESSION["arrivalDate"];
    $vehicleType = $_SESSION["vehicleType"];
    $place = $_SESSION["place"];

    $deliveryStatus = true;



    //-----------------------------------------------------------
    $checkOutTime = date($format, time());

    $from_time = strtotime($checkInTime);
    $to_time = strtotime($checkOutTime);
    $diff_minutes = round(abs($from_time - $to_time) / 60 / 60);
    $time = $diff_minutes;

    if ($vehicleType == 2) {
        $bill = $time * 15 . ' kr';
        echo 'dddd';
    }
    if ($vehicleType == 1) {
        $bill = $time * 25 . ' kr';
    }


    // Parking Class
    $p = new Parking(SERVERNAME, USERNAME, PASSWORD, DBNAME);

    $deliveryOfVehicle = $p->deliveryOfVehicle($regNum, $checkOutTime);

    if ($deliveryOfVehicle) {
        //Unset SESSION
        session_destroy();
        unset($_SESSION);

        //Set SESSION
        session_start();
        $_SESSION["userId"] = $userId;
        $_SESSION["userName"] = $name;
        $_SESSION["userEmail"] = $email;
        $_SESSION["userPassword"] = $password;
        $_SESSION["userGender"] = $gender ;

        $_SESSION["dRegNum"] = $regNum;
        $_SESSION["dVehicleType"] = $vehicleType;
        $_SESSION["dCheckIn"] = $checkInTime;
        $_SESSION["dCheckOut"] = $checkOutTime;
        $_SESSION["dTime"] = $time . ' hours';
        $_SESSION["dBill"] = $bill;


        //Redirect profile.php
        redirect('app/account/profile.php?delivered=1');
    }
}




?>



<?php ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head  -->
    <?php require_once '../../layouts/head.php' ?>
    <title>Delivery of vehicle</title>
</head>

<body onload="">

    <!-- Header Start -->
    <header>
        <!-- Navbar -->
        <?php require_once './layouts/navbar.php' ?>
    </header>
    <!-- Header End -->

    <!-- Main Start -->
    <main>
        <div class=" container">
            <br>
            <br>
            <h1 class="mx-auto w-50">Delivery of vehicle</h1>
            <section class="w-75 m-auto">
                <!-- Form register -->
                <?php if (!$deliveryStatus) { ?>
                    <div class="bg-light p-5 rounded mt-5">
                        <div class="col-10 mx-auto">
                            <?php if (isset($_SESSION["regNum"])) echo '<h4 class="text-info">Vehicle Info</h4>' ?>
                            <hr>
                            <p>
                                <?php if (isset($_SESSION["regNum"])) echo 'Reg Number: ' . $_SESSION["regNum"] ?> <br>
                                <?php if (isset($_SESSION["vehicleType"])) {
                                    if ($_SESSION["vehicleType"] == 1) {
                                        echo 'vehicle type: Car';
                                    } else {
                                        echo 'vehicle type: MC';
                                    }
                                }
                                ?> <br>
                            </p>
                            <hr>
                            <!-- Form -->
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-4 row gx-3 gy-2 align-items-center">
                                <div class="">
                                    <input type="hidden" name="regNumber" class="form-control" placeholder="Your reg-number" value="<?= $_SESSION["regNum"] ?>" readonly>
                                </div>
                                <div class=" ms-auto w-auto mt-3">
                                    <button type="submit" class="btn btn-primary">Leave</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } ?>

                <!--  Bill Info -->
                <?php if ($deliveryStatus) { ?>
                    <br>
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Bill</h4>
                        <p>
                            Reg number: <?= $regNum ?> <br>
                            Full name: <?= $_SESSION["userName"] ?> <br>
                            Email: <?= $_SESSION["userEmail"] ?> <br>
                            Password: <?= $_SESSION["userPassword"] ?> <br>
                            Vehicle Type: <?php
                                            if ($vehicleType == 1) echo 'Car';
                                            else echo 'MC'; ?> <br>
                            Check-in time: <?= $checkInTime ?> <br>
                            Check-out time: <?= $checkOutTime ?> <br>
                            Time: <?= $time ?> hours<br>
                            Bill: <?= $bill ?> <br>
                        </p>
                        <hr>
                    </div>
                <?php } ?>
            </section>
        </div>
    </main>
    <!-- Main End -->

    <!-- script src -->
    <?php require_once '../../layouts/script-src.php' ?>
</body>

</html>