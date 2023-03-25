<?php
//The Current Page Filename
$current_page_name = basename($_SERVER['PHP_SELF'], '.php');
// echo $current_page_name; // return: index


$logoutAlert = false;
// REQUEST_METHOD GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (empty($_GET['logoutAlert'])) $logoutAlert = false;
    else  $logoutAlert = true;
}

// (A) START SESSION
// session_start();


?>

<!-- Navbar Start -->
<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container">
        <!-- LOGO -->
        <a class="navbar-brand" href="<?= asset('account/profile.php') ?>">
            <img src=" <?= asset('assets/images/verified-account.png'); ?>" alt="" width="34" height="34" class=" " />
        </a>

        <ul class="nav nav-pills me-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?= asset('index.php') ?>">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($current_page_name == 'profile') echo 'active' ?>" aria-current="page" href="<?= asset('app/account/profile.php') ?>">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($current_page_name == 'park') echo 'active' ?> <?php if (isset($_SESSION["regNum"])) echo 'disabled' ?>" href="<?= asset('app/account/park.php') ?>">Park...</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($current_page_name == 'delivery') echo 'active' ?> <?php if (!isset($_SESSION["regNum"])) echo 'disabled' ?>" href="<?= asset('app/account/delivery.php') ?>">Delivery...</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($current_page_name == 'move') echo 'active' ?> <?php if (!isset($_SESSION["regNum"])) echo 'disabled' ?>" href="<?= asset('app/account/move.php') ?>">Move...</a>
            </li>

            <?php if ($_SESSION["userName"] == 'Hafizullah') {
                echo '<li class="nav-item"><button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">CSV Files</button> </li>';
            } ?>
        </ul>


        <!-- User Menu-->
        <div>
            <div class="d-flex align-items-center <?php if (!isset($_SESSION["userName"])) echo 'd-none' ?>">
                <div class="flex-shrink-0 dropdown">
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
                            <a class="dropdown-item" href="#">Settings</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= asset('app/account/profile.php?logoutAlert=1') ?>">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
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
            denyButtonText: '<a href="<?php echo asset('account/profile.php') ?>"class="btn btn-sm text-light">No</a>',
        })
    }
</script>
<?php
if ($logoutAlert) {
    echo '<script>ShowAlert()</script>';
}
?>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">CSV Files </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h2 class="fs-5">Users CSV</h2>
                <a href="<?= asset('files/users.csv')?>" class="btn  btn-outline-dark" data-bs-toggle="tooltip" title="Download users.csv" download="users_<?=date("Y/m/d H:i");?>.csv">Download </a>
                    <hr>
                <h2 class="fs-5">Parking CSV</h2>
                <a href=" <?= asset('files/parking.csv')?>" class="btn  btn-outline-dark" data-bs-toggle="tooltip" title="Download parking.csv" download="parking_<?=date("Y/m/d H:i");?>.csv">Download </a>
                
            </div>
            <div class="modal-footer">
                <span class="w-auto me-auto"><?php echo date("Y/m/d H:i");?></span>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>