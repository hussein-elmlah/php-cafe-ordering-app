<?php

require_once 'config/db_info.php';
require_once 'models/User.php';
include 'includes/pagination.php';
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

        $current_page = 1;
        $total_pages = 2; 
        
        $db = Database::getInstance();
        $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $base_query = "SELECT * FROM users";

        $params = [
            'page' => isset($_GET['page']) ? $_GET['page'] : 1,
            'limit' => isset($_GET['limit']) ? $_GET['limit'] : 2,
            'order' => isset($_GET['order']) ? $_GET['order'] : null,
            'search' => isset($_GET['search']) ? $_GET['search'] : null,
        ];

        // var_dump( $params);

        $search_fields = ['name', 'name'];
    
        $result = $db->paramsQuery($base_query, $params, $search_fields);

        $adminUsers = $result['data'];
        $current_page = $result['current_page'];
        $total_pages = $result['total_pages'];

        // Simulate fetching admin users from a database
        // $adminUsers = [
        //     new AdminUser(1, 'Admin 1', 'admin1@example.com'),
        //     new AdminUser(2, 'Admin 2', 'admin2@example.com'),
        //     new AdminUser(3, 'Admin 3', 'admin3@example.com')
        // ];

        // echo "<script>alert('adminUsers: |$adminUsers|');</script>";


        // Include the view file to display admin users
        include './views/admin/admin_users_view.php';

        Pagination($current_page, $total_pages);
    }

    public function editAdminUser($userId) {
        // You can include any necessary logic here to edit
        include 'edit_admin_user_view.php';
    }

    public function deleteAdminUser($userId) {
        // You can include any necessary logic here to delete
        include 'delete_admin_user_confirmation_view.php';
    }
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$userId = isset($_GET['user_id']) ? $_GET['user_id'] : null;

// Instantiate the AdminUserController
$adminUserController = new AdminUserController();

switch ($action) {
    case 'edit':
        if ($userId) {
            $adminUserController->editAdminUser($userId);
        } else {
            echo 'Invalid user ID';
        }
        break;
    case 'delete':
        if ($userId) {
            $adminUserController->deleteAdminUser($userId);
        } else {
            echo 'Invalid user ID';
        }
        break;
    default:
        $adminUserController->displayAdminUsers();
        break;
}
