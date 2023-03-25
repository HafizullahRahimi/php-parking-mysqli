<?php
//require Files
require_once '../../functions/helpers.php';
require_once '../../database/Parking.php';

//The Current Page Filename
$current_page_name = basename($_SERVER['PHP_SELF'], 'php');

// START SESSION
session_start();


//-----------------------------------------------------------
$regNum = "";
$vehicleType = $_SESSION["vehicleType"];
// $vehicleType = 1;


// echo $vehicleType;


// Parking Class
$p = new Parking(SERVERNAME, USERNAME, PASSWORD, DBNAME);

if ($vehicleType == 1) $freePlaceArr = $p->getFreePlacesForCar();
else $freePlaceArr = $p->getFreePlacesForMC();


// REQUEST_METHOD = POST 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST["regNum"]) && !empty($_POST["newPlace"])) {
        $regNum = test_input($_POST["regNum"]);
        $newPlace = $_POST["newPlace"];

        $p->moveVehicle($regNum, $vehicleType, $newPlace);
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head  -->
    <?php require_once '../../layouts/head.php' ?>
    <title>Move a vehicle</title>
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
            <h1 class="mx-auto w-50">Move a vehicle</h1>
            <section class="w-100 m-auto">
                <h3 class="mt-4 ">New Place:</h3>
                <!-- Form register -->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class=" row gx-3 gy-2 align-items-center">
                    <input type="hidden" name="regNum" class="form-control" id="specificSizeInputName" placeholder="Your reg-number" value="<?= $_SESSION["regNum"] ?>">

                    <!-- Radio toggle buttons  -->
                    <?php if ($vehicleType == 1) {
                        for ($i = 0; $i < count($freePlaceArr); $i++){ 
                    ?>
                            <input type="radio" class="btn-check" name="newPlace" id="option<?= $freePlaceArr[$i][0]?>" autocomplete="off" value="<?= $freePlaceArr[$i][0]?>">
                            <label class="btn btn-outline-primary col-3" for="option<?= $freePlaceArr[$i][0] ?>">place <?= $freePlaceArr[$i][0]?></label>
                        <?php }
                    } else {
                        for ($i = 0; $i < count($freePlaceArr); $i++) {  ?>
                            <input type="radio" class="btn-check" name="newPlace" id="option<?= $freePlaceArr[$i][0] . $freePlaceArr[$i][1] ?>" autocomplete="off" value="<?=  $freePlaceArr[$i][2] ?>">
                            <label class="btn btn-outline-primary col-2" for="option<?= $freePlaceArr[$i][0] . $freePlaceArr[$i][1] ?>">place <?= $freePlaceArr[$i][0] . '-' . $freePlaceArr[$i][1] ?></label>
                    <?php }
                    } ?>

                    <br>
                    <div class="ms-auto w-25 mt-3 mt-4">
                        <button type="submit" class="btn btn-primary col-12">Move</button>
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