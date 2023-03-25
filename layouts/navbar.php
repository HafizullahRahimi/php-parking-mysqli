<?php
//The Current Page Filename
$current_page_name = basename($_SERVER['PHP_SELF'], '.php');
// echo $current_page_name; // return: index


//START SESSION
// session_start();


$logoutAlert = false;

// REQUEST_METHOD GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (empty($_GET['logoutAlert'])) $logoutAlert = false;
    else  $logoutAlert = true;
}

?>

<!-- Navbar Start -->
<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container">
        <!-- LOGO -->
        <a class="navbar-brand" href="<?= asset('index.php') ?>">
            <img src=" <?= asset('assets/images/house.png'); ?>" alt="" width="34" height="34" class=" " />
        </a>
        <!-- Menu BTN -->
        <button class="navbar-toggler ms-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Search and User Menu-->
        <div>
            <div class="d-flex align-items-center <?php if (!isset($_SESSION["userName"])) echo 'd-none' ?>">
                <!-- Search Form -->
                <!-- <form class="w-100 me-3 d-flex" role="search">
                    <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
                    <button type="submit" class="me-4 ms-2 btn btn-success ">Search</button>
                </form> -->

                <!-- User Menu -->
                <div class="flex-shrink-0 dropdown me-5">
                    <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php if ($_SESSION["userName"] == 'Hafizullah') {
                                        echo asset('assets\images\administrator.png');
                                    } else {
                                        echo asset('assets\images\user.png');
                                    } ?>" alt="mdo" width="32" height="32" class="rounded-circle" />
                        <?= $_SESSION["userName"] ?>
                    </a>
                    <ul class="dropdown-menu text-small">
                        <li>
                            <a class="dropdown-item <?php if (isset($_SESSION["regNum"])) echo 'disabled' ?>" href="<?= asset('app/account/park.php') ?>">Park new vehicle</a>
                        </li>
                        <li>
                            <a class="dropdown-item <?php if (!isset($_SESSION["regNum"])) echo 'disabled' ?>" href="<?= asset('app/account/delivery.php') ?>">Delivery of vehicle</a>
                        </li>
                        <li>
                            <a class="dropdown-item <?php if (!isset($_SESSION["regNum"])) echo 'disabled' ?>" href="<?= asset('app/account/move.php') ?>">Move the vehicle</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Settings</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= asset('app/account/profile.php') ?>">Profile</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= asset('app/index.php?logoutAlert=1') ?>">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Login and Sign up -->
        <div class="col-md-3 text-end ms-auto <?php if (isset($_SESSION["userName"])) echo 'd-none' ?>">
            <a class="btn btn-primary  me-2 <?php if ($current_page_name == 'login') echo 'active'; ?>" href="<?= asset('/auth/login.php') ?>">
                Login
            </a>
            <a class="btn btn-outline-primary <?php if ($current_page_name == 'singup') echo 'active'; ?>" href="<?= asset('/auth/register.php') ?>">
                Sign up
            </a>
        </div>
    </div>
</nav>
<!-- Navbar End -->


<!-- Logout question Alert-->
<script>
    function ShowAlert() {
        Swal.fire({
            title: '<h2 class="fw-semibold">Are you sure to logout?</h2>',
            showDenyButton: true,
            focusConfirm: false,
            confirmButtonText: '<form method="post" action="<?php echo asset('auth/logout.php') ?>"><input type="hidden" name="logout" value="1"><input class="btn btn-sm text-light" type="submit" value="Yes" > </form>',
            denyButtonText: '<a href="<?php echo asset('index.php') ?>"class="btn btn-sm text-light">No</a>',
        })
    }
</script>
<?php
if ($logoutAlert) {
    echo '<script>ShowAlert()</script>';
}
?>