<?php

// require_once "utilities/redirectToView.php";

$requestView = $_GET['view'] ?? '';
$isLoggedIn = @$_SESSION['is_auth'];
// $loggedUser = array(
//     'isAdmin' => @$_SESSION['is_admin'],
//     'first_name' => @$_SESSION['user_name']
// );

switch ($requestView) {
    case "":
    case "home":
        if ($isLoggedIn) {
            include 'controllers/user_home_controller.php';
            break;
        }
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

    case 'admin-users':
        if (!$isAdmin) {
            $baseHref = rtrim(dirname($_SERVER['PHP_SELF']), '/');
            $url = "http://$_SERVER[HTTP_HOST]$baseHref/";
            echo "<script>window.location.href = '$url';</script>";
        } else {
            include 'controllers/admin_users_controller.php';
        }
        break;

    case 'admin-home':
        if (!$loggedUser['isAdmin']) {
            break;
        };
        include 'controllers/admin_home_controller.php';
        break;

    case 'admin-categories':
        // if (!$loggedUser['isAdmin']){ break; }; // admin guard
        include 'controllers/category_controller.php';
        break;

    case 'admin-products':
        // if (!$loggedUser['isAdmin']){ break; }; // admin guard
        include 'controllers/admin_products_controller.php';
        break;
    case 'admin-orders':
        // if (!$loggedUser['isAdmin']){ break; }; // admin guard
        include 'controllers/admin_orders_controller.php';
        break;
    case 'admin-checks':
        // if (!$loggedUser['isAdmin']){ break; }; // admin guard
        include 'controllers/admin_checks_controller.php';
        break;
    case 'user-orders':
        // if (!$loggedUser['isAdmin']){ break; }; // admin guard
        include 'controllers/user_orders_controller.php';
        break;
    default:
        include 'views/404.php';
        break;
}
