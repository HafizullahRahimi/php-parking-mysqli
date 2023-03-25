<?php
//require Files
require_once '../functions/helpers.php';
require_once '../database/User.php';



// REQUEST_METHOD POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstName = test_input($_POST["firstName"]);
    $lastName = test_input($_POST["lastName"]);
    $email = test_input($_POST["email"]);
    $gender = test_input($_POST["gender"]);
    $password = test_input($_POST["password"]);
    $conPassword = test_input($_POST["conPassword"]);
    $img;
    if (empty($_POST["img"])) $img = 'user.png';
    
    // User Class
    $u = new User(SERVERNAME, USERNAME, PASSWORD, DBNAME);
    // register new User
    $u->register($firstName, $lastName, $email, $password, $gender, $img);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head  -->
    <?php require_once '../layouts/head.php' ?>
    <title>Register</title>
</head>

<body onload="">

    <!-- Header Start -->
    <header>
    </header>
    <!-- Header End -->

    <!-- Main Start -->
    <main>
        <div class=" container">
            <!-- Form register -->
            <section class="mx-auto col-4 my-3 ">
                <h1 class="mb-3">Register</h1>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="row g-3 needs-validation" novalidate>
                    <!-- First name Part -->
                    <div class="col-md-12">
                        <label for="validationCustom01" class="form-label">First name</label>
                        <input type="text" name="firstName" class="form-control" id="validationCustom01" value="" required />
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                    <!-- Last name Part -->
                    <div class="col-md-12">
                        <label for="validationCustom02" class="form-label">Last name</label>
                        <input type="text" name="lastName"  class="form-control" id="validationCustom02" value="" required />
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                    <!-- Email Part -->
                    <div class="col-md-12">
                        <label for="validationCustom03" class="form-label">Email</label>
                        <input type="email" name="email"  class="form-control" id="validationCustom03" required />
                        <div class="invalid-feedback">
                            Please provide a valid Email.
                        </div>
                    </div>
                    <!-- Gender Part -->
                    <div class="d-flex ">
                        Gender:
                        <div class="form-check ms-3">
                            <input type="radio" name="gender" value="0" class="form-check-input" id="validationFormCheck2"  required />
                            <label class="form-check-label" for="validationFormCheck2">Female</label>
                        </div>
                        <div class="form-check ms-3">
                            <input type="radio" name="gender" value="1"  class="form-check-input" id="validationFormCheck3"  required />
                            <label class="form-check-label" for="validationFormCheck3">Male</label>
                        </div>
                        <div class="form-check ms-3 d-flex">
                            <input type="radio" name="gender" value="3" class="form-check-input" id="validationFormCheck4"  required />
                            <label class="form-check-label ms-2" for="validationFormCheck4">Other</label>
                        </div>
                    </div>

                    <!-- New password Part -->
                    <div class="col-md-12">
                        <label for="validationCustom06" class="form-label">New password</label>
                        <input type="password" name="password" class="form-control" id="validationCustom07" value="" required />
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                    <!-- Confirm password Part -->
                    <div class="col-md-12">
                        <label for="validationCustom02" class="form-label">Confirm password</label>
                        <input type="password" name="conPassword" class="form-control" id="validationCustom07" value="" required />
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                    <!-- Image Part -->
                    <div class="mb-3">
                        <label class="form-check-label mb-2">Image</label>
                        <input type="file" name="img" class="form-control" aria-label="file example">
                        <!-- <div class="invalid-feedback">Example invalid form file feedback</div> -->
                    </div>
                    <!-- Agree Part -->
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required />
                            <label class="form-check-label" for="invalidCheck">
                                Agree to terms and conditions
                            </label>
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>

                    <!-- Submit Part -->
                    <div class="">
                        <button class="btn btn-primary w-100" type="submit">Register</button>
                    </div>
                    <div class="mt-4">
                        Already a user <a href="<?= asset('/auth/login.php') ?>" class="text-black">LOGIN</a>
                    </div>
                    <div class="mt-4 ">
                        <a href="<?= asset('index.php') ?>" class="btn  btn-outline-secondary  w-100">Go Home</a>
                    </div>
                </form>
            </section>
            <!-- </section> -->
        </div>
    </main>
    <!-- Main End -->

    <!-- script src -->
    <script src="<?= asset('assets/js/validation-form.js') ?>"></script>
    <?php require_once '../layouts/script-src.php' ?>
</body>

</html>