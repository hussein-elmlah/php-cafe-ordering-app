<?php

$requestPage = $_GET['page'] ?? '';

// Temporary placeholder values for user role, first name and isLoggedIn
$isLoggedIn = true;
$loggedUser = array(
    'isAdmin' => true,
    'first_name' => 'Hussein'
);

switch ($requestPage) {
    case null:
        // Include admin-home controller
        break;
    case '':
        // Include admin-home controller
        break;
    case '/':
        // Include admin-home controller
        break;
    case '#':
        // Include admin-home controller
        break;
    case 'admin-users':
        // if (!$loggedUser['isAdmin']){ break; }; // admin guard
        include 'views/admin/admin_users_view.php';
        break;
    default:
        include 'views/404.php';
        break;
}

?>
