<?php
//require Files
require_once '../functions/helpers.php';
require_once '../database/User.php';

// (A) START SESSION
session_start();



// -------------------------------------------------------
$email = $password = $err = "";
$loginStatus = false;



// REQUEST_METHOD POST FORM
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    
    // echo $email;
    // echo '<br>';
    // echo $password;

    $u = new User(SERVERNAME, USERNAME, PASSWORD, DBNAME);
    // User Class
    $loginStatus =  $u->login($email, $password);
    if (!$loginStatus) {
        $err = 'Email or Password is false!!';
    }


}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head  -->
    <?php require_once '../layouts/head.php' ?>
    <title>Login</title>
</head>

<body onload="">
    <!-- Main Start -->
    <main>
        <div class=" container">
            <br>
            <br>
            <!-- Form Login -->
            <section class="mx-auto mt-3" style="width: 300px;">
                <h1 class="">Login</h1>
                <!-- <form  class="mt-4 row gx-3 gy-2 align-items-center"> -->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="row g-3 needs-validation" novalidate>
                    <!-- Email -->
                    <span class=" text-danger "><?php echo $err ?></span>
                    <div class="col-md-12">
                        <label for="validationCustom03" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="validationCustom03" value="<?php if (!$loginStatus) echo $email; ?>" required />
                        <div class="invalid-feedback">
                            Please provide a valid Email.
                        </div>
                    </div>
                    <!-- Password -->
                    <div class="col-md-12">
                        <label for="validationCustom07" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="validationCustom07" value="<?php if (!$loginStatus) echo $password;?>" required />
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">
                            Please provide a valid Password.
                        </div>
                    </div>
                    <!-- Remember me? Part -->
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="invalidCheck" />
                            <label class="form-check-label" for="invalidCheck">
                                Remember me?
                            </label>
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <!-- Submit -->
                    <div class="mt-4">
                        <button type="submit" class="w-100 btn btn-primary">Login</button>
                    </div>
                </form>
                <!-- Forget Password? -->
                <div class="mt-2 ms-auto " style="width: 130px;">
                    <a href="" class="text-black-50">Forget Password?</a>
                </div>
                <div class="mt-4">
                    Need an account? <a href="<?= asset('/auth/register.php') ?>" class="text-black">SING UP</a>
                </div>
                <div class="mt-4 ">
                    <a href="<?= asset('index.php') ?>" class="btn  btn-outline-secondary  w-100">Go Home</a>
                </div>

            </section>
        </div>
    </main>
    <!-- Main End -->

    <!-- script src -->
    <script src="<?= asset('assets/js/validation-form.js') ?>"></script>
    <?php require_once '../layouts/script-src.php' ?>
</body>

</html>