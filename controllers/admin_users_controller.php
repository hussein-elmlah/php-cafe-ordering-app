<?php

// include (realpath(dirname(__FILE__)."config/db_info.php"));
require_once 'config/db_info.php';
require_once 'db/db_class.php';
// require_once 'models/User.php';
include 'includes/pagination.php';

// class AdminUser {
//     public $id;
//     public $name;
//     public $email;

//     public function __construct($id, $name, $email) {
//         $this->id = $id;
//         $this->name = $name;
//         $this->email = $email;
//     }
// }

class AdminUserController {
    private $db;

    public function __construct (){
        $this->db = Database::getInstance();
        $this->db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    }
    public function addAdminUser() {
        [
            "name" => $name,
            "email" => $email,
            "password" => $password,
            "room" => $room,
            "ext" => $ext,
            "profile" => $profile
        ] = $_POST;

        // echo $name, $email, $password;
        $inserted = $this->db->insert("users", "name, email, password, room, ext, profile", "'$name', '$email', '$password', $room, '$ext', '$profile'");

        // include 'views/admin/admin_users_view.php';
    }

    public function viewAddAdminUser() {
        
        $roomQuery = "SELECT * FROM rooms";
        $rooms = $this->db->customQuery($roomQuery);

        include 'views/admin/admin_add_user_view.php';
    }

    public function displayAdminUsers() {

        $current_page = 1;
        $total_pages = 2; 

        $base_query = "SELECT * FROM users";

        $params = [
            'page' => isset($_GET['page']) ? $_GET['page'] : 1,
            'limit' => isset($_GET['limit']) ? $_GET['limit'] : 2,
            'order' => isset($_GET['order']) ? $_GET['order'] : null,
            'search' => isset($_GET['search']) ? $_GET['search'] : null,
        ];
        $search_fields = ['name', 'name'];
    
        $result = $this->db->paramsQuery($base_query, $params, $search_fields);

        $adminUsers = $result['data'];
        $current_page = $result['current_page'];
        $total_pages = $result['total_pages'];



        // Include the view file to display admin users
        include 'views/admin/admin_users_view.php';

        Pagination($current_page, $total_pages);
    }

    public function editAdminUser($userId) {
        // You can include any necessary logic here to edit
        include 'edit_admin_user_view.php';
    }

    public function deleteAdminUser($userId) {
        $delete = $this->db->delete("users", $userId);
        $this->displayAdminUsers();
    }
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$userId = isset($_GET['user_id']) ? $_GET['user_id'] : null;
$data = isset($_GET['data']) ? $_GET['data'] : null;

// Instantiate the AdminUserController
$adminUserController = new AdminUserController();

switch ($action) {
    case 'add':
        $adminUserController->viewAddAdminUser($data);
        break;

    case 'create':
        $adminUserController->addAdminUser($data);
        break;

    case 'edit':
        if ($userId) {
            // $adminUserController->editAdminUser($userId);
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

?>
