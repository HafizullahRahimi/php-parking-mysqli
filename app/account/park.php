<?php
//require Files
require_once '../../functions/helpers.php';
require_once '../../database/Bill.php';
require_once '../../database/Parking.php';

//The Current Page Filename
$current_page_name = basename($_SERVER['PHP_SELF'], 'php');

//Time Zone Sweden
date_default_timezone_set("Europe/Stockholm");
$format = "Y/m/d H:i:s"; //2023/02/07 18:48:54

// echo ' Park new vehicle page';

// START SESSION
session_start();

?>

<?php


$place = $regNum = $name = $vehicleType  = "";

// REQUEST_METHOD POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION["userId"];
    $numPlate = test_input($_POST["numPlate"]);
    $vehicleType = test_input($_POST["vehicleType"]);

    //-----------------------------------------------------------
    // Parking Class
    $p = new parking(SERVERNAME, USERNAME, PASSWORD, DBNAME);
    $p->parkNewVehicle($vehicleType, $numPlate, $userId);

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head  -->
    <?php require_once '../../layouts/head.php' ?>
    <title>Park new vehicle</title>
</head>

<body onload="">

    <!-- Header Start -->
    <header>
        <!-- Navbar -->
        <?php //require_once './layouts/navbar.php' 
        ?>
    </header>
    <!-- Header End -->


    <!-- Main Start -->
    <main>
        <div class=" container">
            <br>
            <br>
            <h1 class="mx-auto w-50">Park new vehicle</h1>
            <section class="w-50 m-auto">
                <!-- Form register -->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-4 row gx-3 gy-2 align-items-center">

                    <div class="">
                        <label class="mb-2" for="specificSizeInputName">Number plate:</label>
                        <input type="text" name="numPlate" class="form-control" id="specificSizeInputName" value="" required>
                    </div>

                    <div class="">
                        <!-- <p>Vehicle Type:</p> -->
                        <label>Vehicle Type:</label>
                        <br>
                        <input class="form-check-input" type="radio" name="vehicleType" id="inlineRadio1" value="1" checked>
                        <label class="form-check-label" for="inlineRadio1">Car</label>

                        <input class="form-check-input" type="radio" name="vehicleType" id="inlineRadio2" value="2">
                        <label class="form-check-label" for="inlineRadio2">MotorC</label>
                    </div>

                    <div class=" ms-auto w-auto">
                        <button type="submit" class=" btn btn-primary ">Park Now</button>
                    </div>
                </form>
                <br>

            </section>
        </div>
    </main>
    <!-- Main End -->



    <!-- script src -->
    <?php require_once '../../layouts/script-src.php' ?>
</body>

</html>