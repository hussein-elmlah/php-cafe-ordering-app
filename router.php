<?php

$requestView = $_GET['view'] ?? '';

switch ($requestView) {
    case 'null':
        // Include admin-home controller here
        redirectToView('admin-users'); // delete later
        break;
    case 'register':
        include 'controllers/user_controller.php';
        break;
    case 'logout':
        if (session_status() != PHP_SESSION_NONE) {
            session_destroy();
        }
        $baseHref = rtrim(dirname($_SERVER['PHP_SELF']), '/');
        $url = "http://$_SERVER[HTTP_HOST]$baseHref/";
        echo "<script>window.location.href = '$url';</script>";
        break;
    case 'login':
        include 'controllers/user_controller.php';
        break;
    case 'admin-users':
        if (!$isAdmin) {     // admin guard
            $baseHref = rtrim(dirname($_SERVER['PHP_SELF']), '/');
            $url = "http://$_SERVER[HTTP_HOST]$baseHref/";
            echo "<script>window.location.href = '$url';</script>";
            break;
        }else{
            include 'controllers/admin_users_controller.php';
        }
        break;
    default:
        include 'views/404.php';
        break;
}
