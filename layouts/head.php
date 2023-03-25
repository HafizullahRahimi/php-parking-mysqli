<?php
//require Files
// require_once '../functions/helpers.php';


//The Current Page Filename
$current_page_name = basename($_SERVER['PHP_SELF'], 'php');

?>


<!-- head -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Animate -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="<?= asset('assets/fontawesome-free-6.2.1-web/css/all.css') ?>" />

    <!-- Bootstrap -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="<?= asset('assets/css/bootstrap.css') ?>" />

    <link rel="stylesheet" href="<?= asset('assets/fonts/font.css') ?>" />
    <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>" />

    <!-- SweetAlert2 -->
    <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <script src=" <?= asset('assets/js/sweetalert2.all.js') ?>"></script>

    <link rel="icon" href="<?= asset('assets/images/parking.png') ?>" />
    

<!-- head -->