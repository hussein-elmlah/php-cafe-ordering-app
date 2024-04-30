<?php

require_once 'config/db_info.php';
require_once 'db/db_class.php';
include 'includes/pagination.php';
require_once "utilities/redirectToView.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// initialize settings to display error messages
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Cafe!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p {
            margin: 0;
            padding: 0;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/material-icons@1.13.12/iconfont/material-icons.min.css" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container" style="min-height: 78vh">
        <?php include 'router.php'; ?>
    </div>
    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>