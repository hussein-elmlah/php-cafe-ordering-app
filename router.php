<?php

require_once "utilities/redirectToView.php";

$requestView = $_GET['view'] ?? '';

// Temporary placeholder values
$loggedUser = array(
    'isAdmin' => true,
    'first_name' => 'Hussein'
);

switch ($requestView) {
    case 'null':
        // Include admin-home controller here
        redirectToView('admin-users'); // delete later
        break;
    case '':
        // Include admin-home controller here
        break;
    case '/':
        // Include admin-home controller here
        break;
    case '#':
        // Include admin-home controller here
        redirectToView('admin-users'); // delete later
        break;
    case 'admin-users':
        if (!$loggedUser['isAdmin']){ break; }; // admin guard
        include 'controllers/admin_users_controller.php';
        break;
    case 'admin-categories':
        // if (!$loggedUser['isAdmin']){ break; }; // admin guard
        include 'controllers/category_controller.php';
        break;   
    case 'admin-products':
        // if (!$loggedUser['isAdmin']){ break; }; // admin guard
        include 'controllers/admin_products_controller.php';
        break; 
    default:
        include 'views/404.php';
        break;
}

?>
