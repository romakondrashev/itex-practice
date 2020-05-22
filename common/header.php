<?php require "connection.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Онлайн Очередь ХНУРЭ</title>
    <link href="<?php echo $home_url; ?>/assets/css/styles.css" rel="stylesheet" />
    <link href="<?php echo $home_url; ?>/assets/css/main.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <script src="<?php echo $home_url; ?>/assets/js/vendor/jquery-3.4.1.min.js"></script>
    <script src="<?php echo $home_url; ?>/assets/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $home_url; ?>/assets/js/scripts.js"></script>
</head>
<body class="sb-nav-fixed">
    <?php require 'common/top-bar.php'; ?>
    <div id="layoutSidenav">
        <?php require 'common/menu.php'; ?>

        <div id="layoutSidenav_content">