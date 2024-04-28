<?php

// require_once "utilities/redirectToView.php";

$requestView = $_GET['view'] ?? '';

// Temporary placeholder values
$loggedUser = array(
    'isAdmin' => true,
    'first_name' => 'Hussein'
);

switch ($requestView) {
    case 'null':
    case '':
    case '/':
    case '#':
    case 'admin-home':
        // admin guard
        if (!$loggedUser['isAdmin']) {
            break;
        };
        include 'controllers/admin_home_controller.php';
        break;
    case 'admin-users':
        // admin guard
        if (!$loggedUser['isAdmin']) {
            break;
        };
        include 'controllers/admin_users_controller.php';
        break;
    default:
        include 'views/404.php';
        break;
}
