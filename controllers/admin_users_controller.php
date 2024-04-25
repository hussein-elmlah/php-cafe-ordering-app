<?php

require_once 'config/db_info.php';
require_once 'models/User.php';
require_once 'helpers/query_helper.php';
class AdminUser {
    public $id;
    public $name;
    public $email;

    public function __construct($id, $name, $email) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }
}

class AdminUserController {
    public function displayAdminUsers() {

        $db = Database::getInstance();
        $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $base_query = "SELECT * FROM users";

        $params = [
            'page' =>  1,
            'limit' =>  3,
            'order' =>  'email',
            'search' => 'Adm',
        ];

        // var_dump( $params);

        $search_fields = ['name', 'name'];

        $modified_query = handle_query_params($base_query, $params, $search_fields);
    
        $adminUsers = $db->customQuery($modified_query);

        // Simulate fetching admin users from a database
        // $adminUsers = [
        //     new AdminUser(1, 'Admin 1', 'admin1@example.com'),
        //     new AdminUser(2, 'Admin 2', 'admin2@example.com'),
        //     new AdminUser(3, 'Admin 3', 'admin3@example.com')
        // ];

        // echo "<script>alert('adminUsers: |$adminUsers|');</script>";


        // Include the view file to display admin users
        include './views/admin/admin_users_view.php';
    }

    public function editAdminUser($userId) {
        // You can include any necessary logic here to edit the admin user with the given ID
        // For demonstration purposes, let's assume we have an edit form in a separate view file
        include 'edit_admin_user_view.php';
    }

    public function deleteAdminUser($userId) {
        // You can include any necessary logic here to delete the admin user with the given ID
        // For demonstration purposes, let's assume we have a confirmation message in a separate view file
        include 'delete_admin_user_confirmation_view.php';
    }
}

// Example usage:
$action = isset($_GET['action']) ? $_GET['action'] : '';
$userId = isset($_GET['user_id']) ? $_GET['user_id'] : null;

// Instantiate the AdminUserController
$adminUserController = new AdminUserController();

switch ($action) {
    case 'edit':
        if ($userId) {
            $adminUserController->editAdminUser($userId);
        } else {
            // Handle error
            echo 'Invalid user ID';
        }
        break;
    case 'delete':
        if ($userId) {
            $adminUserController->deleteAdminUser($userId);
        } else {
            // Handle error
            echo 'Invalid user ID';
        }
        break;
    default:
        // Display admin users by default
        $adminUserController->displayAdminUsers();
        break;
}

?>
