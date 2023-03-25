<?php
//require Files
require_once '../functions/helpers.php';
require_once '../database/Parking.php';


//The Current Page Filename
$current_page_name = basename($_SERVER['PHP_SELF'], 'php');

//Time Zone Sweden
date_default_timezone_set("Europe/Stockholm");
$format = "Y/m/d H:i:s"; //2023/02/07 18:48:54

//START SESSION
session_start();

//-----------------------------------------------------------
// Parking Class
$p = new Parking(SERVERNAME, USERNAME, PASSWORD, DBNAME);

// Parking Arr
$parkingArr = $p->getParkingInfo();
$arrLength = count($parkingArr);


//-----------------------------------------------------------
// REQUEST_METHOD POST For Find regNum
$findRegNum = false;
$showAlert = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["regNum"])) {
        $regNum = $_POST["regNum"];
        $showAlert = true;

        // regNum Arr
        $regNumArr = $p->getRegnumInfo($regNum);

        // Found regNum
        if (!empty($regNumArr)) {
            $findRegNum = true;
            $fullNameF = $regNumArr['first_name'] . ' ' . $regNumArr['last_name'];
            $emailF = $regNumArr['email'];
            $vehicleTypeF;
            if ($regNumArr["vehicle_type"] == 1) $vehicleTypeF = 'Car';
            else  $vehicleTypeF = 'MC';
            $arrivalF = $regNumArr["arrival_date"];
            $placeF = $regNumArr["place"];
            $partF = $regNumArr["part"];
        }
    }
}




?>
<?php ?>



<!-- Prague parking HTML-->
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head  -->
    <?php require_once '../layouts/head.php' ?>
    <title>Home</title>
</head>

<body onload="">

    <!-- Header Start -->
    <header>
        <div class="Header-top col-8 mx-auto">
            <h1 class="my-4 w-25 mx-auto ">Parking</h1>
            <div class="d-flex align-items-center mb-5 <?php if (!isset($_SESSION["userName"])) echo 'd-none'; ?>">
                <!-- Search Form -->
                <form class="w-100 me-3 d-flex" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input name="regNum" type="text" class="form-control" placeholder="Reg number" aria-label="Search">
                    <button type="submit" class="me-4 ms-2 btn btn-success ">Find</button>
                </form>
            </div>
        </div>
        <!-- Navbar -->
        <?php require_once '../layouts/navbar.php' ?>
    </header>
    <!-- Header End -->

    <!-- Main Start -->
    <main>
        <div class=" container">
            <br>
            <h1>Places:</h1>
            <section class="d-flex flex-wrap flex-row w-100 mx-auto">
                <!-- Place card -->
                <?php for ($row = 1; $row < $arrLength; $row++) { ?>
                    <section class=" col-lg-3 col-md-4 col-sm-6 ">
                        <div class="card mx-1 my-2 pt-0 <?php if ($parkingArr[$row][1] !== null && $parkingArr[$row][2] !== null) echo 'bg-info' ?>">
                            <h4 class="ms-2 mt-1">
                                <?php
                                // Place is free for A Car
                                if ($parkingArr[$row][1] == null && $parkingArr[$row][2] == null) {
                                    echo '<span class="badge bg-dark-subtle">';
                                    echo $parkingArr[$row][0];
                                    echo "</span>";
                                }
                                // Place: A Car
                                if ($parkingArr[$row][1] == $parkingArr[$row][2]  && $parkingArr[$row][1] !== null) {
                                    echo '<span class="badge bg-danger">';
                                    echo $parkingArr[$row][0];
                                    echo "</span>";
                                    echo '<span class="ms-1 badge bg-info">1 <i class="fa-solid fa-car-side"></i></span>';
                                }
                                // Place: 2 MC
                                if ($parkingArr[$row][1] !== $parkingArr[$row][2]  && $parkingArr[$row][1] !== null && $parkingArr[$row][2] !== null) {
                                    echo '<span class="badge bg-danger">';
                                    echo $parkingArr[$row][0];
                                    echo "</span>";
                                    echo '<span class="badge ms-1 bg-info">2/2 <i class="fa-solid fa-motorcycle"></i></span>';
                                }
                                // part1: a MC
                                if ($parkingArr[$row][1] !== $parkingArr[$row][2]  && $parkingArr[$row][1] == null) {
                                    echo '<span class="badge bg-warning">';
                                    echo $parkingArr[$row][0];
                                    echo "</span>";
                                    echo '<span class="badge ms-1 bg-info">1/2 <i class="fa-solid fa-motorcycle"></i></span>';
                                }
                                // part2: a MC
                                if ($parkingArr[$row][1] !== $parkingArr[$row][2]  && $parkingArr[$row][2] == null) {
                                    echo '<span class="badge bg-warning">';
                                    echo $parkingArr[$row][0];
                                    echo "</span>";
                                    echo '<span class="badge ms-1 bg-info">1/2 <i class="fa-solid fa-motorcycle"></i></span>';
                                }
                                // part1: a MC part2: a MC
                                // if ($parkingArr[$row][1] !== $parkingArr[$row][2]  && $parkingArr[$row][1] == null && $parkingArr[$row][2] == null) {
                                //     echo '<span class="badge bg-warning">';
                                //     echo $parkingArr[$row][0];
                                //     echo "</span>";
                                //     echo '<span class="badge ms-1 bg-info">5 <i class="fa-solid fa-motorcycle"></i></span>';
                                // }

                                ?>
                            </h4>
                            <div class="card-body">
                                <div class="list-group ">
                                    <!-- Part 1 -->
                                    <?php if ($parkingArr[$row][1] !== null) echo '' ?>
                                    <a href="#" class="list-group-item list-group-item-action <?php if ($parkingArr[$row][1] !== null) echo 'bg-info' ?>" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between ">
                                            <h5 class="mb-1">1 </h5>
                                            <button class="btn position-relative  <?php if ($parkingArr[$row][1] !== null) echo 'text-white' ?> ">
                                                <?php if ($parkingArr[$row][1] !== null) {
                                                    // if user logged
                                                    if (isset($_SESSION["userName"])) {
                                                        echo $parkingArr[$row][1];
                                                    } else  echo '----';
                                                } else echo null; ?>
                                            </button>
                                        </div>
                                    </a>
                                    <!-- Part 2 -->
                                    <a href="#" class="list-group-item list-group-item-action <?php if ($parkingArr[$row][2] !== null) echo 'bg-info' ?>" aria-current="true">
                                        <div class="d-flex w-100 justify-content-between ">
                                            <h5 class="mb-1">2 </h5>
                                            <button class="btn position-relative  <?php if ($parkingArr[$row][2] !== null) echo 'text-white' ?> ">
                                                <?php if ($parkingArr[$row][2] !== null) {
                                                    // if user logged
                                                    if (isset($_SESSION["userName"])) {
                                                        echo $parkingArr[$row][2];
                                                    } else echo '----';
                                                } else echo null; ?>
                                            </button>
                                        </div>
                                    </a>
                                    <!-- <a href="#" class="list-group-item list-group-item-action " aria-current="true">
                                        <div class="d-flex w-100 justify-content-between ">
                                            <h5 class="mb-1">2</h5>
                                            <button class="btn position-relative  ">
                                                Free
                                            </button>
                                        </div>
                                    </a> -->
                                </div>
                            </div>
                        </div>
                    </section>

                <?php } ?>
            </section>
        </div>
    </main>
    <!-- Main End -->


    <!-- SweetAlert -->
    <script>
        function regNumFound() {
            Swal.fire({
                title: '<h2 class="fs-4"><?= $regNum ?></h2>',
                icon: 'success',
                html: '<div class="modal-body text-start col-8 mx-auto">' +
                    '<hr>' +
                    '<h4 class="fs-6">Full name: <?= $fullNameF ?></h4>' +
                    '<h4 class="fs-6">Email: <?= $emailF ?></h4>' +
                    '<hr>' +
                    '<h4 class="fs-6">Vehicle type: <?= $vehicleTypeF ?></h4>' +
                    '<h4 class="fs-6">Arrival date: <?= $arrivalF ?></h4>' +
                    '<h4 class="fs-6">Place: <?= $placeF ?></h4>' +
                    '<h4 class="fs-6">Part: <?= $partF ?></h4>' +
                    '<hr>' +
                    '</div>',
                showCloseButton: true,
                showCancelButton: false,
                focusConfirm: false,
                showConfirmButton: false,
            })
        }
    </script>
    <script>
        function regNumNotFound() {
            Swal.fire({
                icon: 'error',
                title: '<h2 class="fs-3"> Oops...</h2>',
                showCloseButton: true,
                showConfirmButton: false,
                html: '<h4 class="fs-6 text-danger">No Vehicles Found!!</h4>',
                footer: '<a href="">Why do I have this issue?</a>'
            })
        }
    </script>

    <?php
    if ($showAlert && !$findRegNum) echo '<script>regNumNotFound()</script>';
    if ($showAlert && $findRegNum) echo '<script>regNumFound()</script>';
    ?>



    <!-- script src -->
    <?php require_once '../layouts/script-src.php' ?>
</body>

</html>