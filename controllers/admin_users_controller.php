<?php
session_start();
// include (realpath(dirname(__FILE__)."config/db_info.php"));
require_once 'vendor/autoload.php';
use Respect\Validation\Validator as DataValidation;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Exceptions\ValidationException;
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
        
        $profile = $_FILES['profile']['tmp_name'];
        $isEmail = DataValidation::email(); 
        $isImage = DataValidation::image(); 

        try {
            DataValidation::stringType()->length(8, null)->check($_POST['password']);
            DataValidation::stringType()->length(8, null)->check($_POST['password_confirmation']);
            DataValidation::keyValue('password_confirmation', 'equals', 'password')->check($_POST);
            $isEmail->check($_POST['email']);
            $isImage->check($profile);
            
            $_POST['profile'] = file_get_contents($profile);
            $this->db->insert("users", "name,email,password,room,ext,profile",
                             ":name,:email,:password,:room,:ext,:profile", $_POST);
            $_SESSION['msg'] = "User is added successfully";
        } catch(ValidationException $exception) {
            $_SESSION['error'] = $exception->getMessage();
        }
        echo '<script> 
                window.location.href = window.location.pathname + "?view=admin-users";
              </script>';
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
        $roomQuery = "SELECT * FROM rooms";
        $rooms = $this->db->customQuery($roomQuery);
        $userData = $this->db->customQuery("SELECT * FROM users WHERE id=$userId");
        include 'views/admin/admin_edit_user_view.php';
        return $userData;
    }

    public function updateAdminUser($userId, $user_data) {

        // if a new image is uploaded.
        $_POST['room'] = intval($_POST['room']);
        
        if (($_FILES['profile']['tmp_name'])) {
            $profile = file_get_contents($_FILES['profile']['tmp_name']);
            $_POST['profile'] = $profile;
        }

        $db_fields = array_keys($user_data[0]);
        array_shift($db_fields);
        $fields = '';
        $fields_to_be_updated = '';
        $values_to_be_updated = [];
        
        foreach ($db_fields as $field) {
            if ( isset($_POST[$field]) && $user_data[0][$field] !== $_POST[$field]) {
                $fields .= "$field=:$field,";
                $fields_to_be_updated .= ":$field,";
                $values_to_be_updated[] = $_POST[$field];
            }            
        }
        $fields = rtrim($fields, ","); 
        $fields_to_be_updated = rtrim($fields_to_be_updated, ","); 
        if (count($values_to_be_updated) > 0) {
            $this->db->update("users", $userId, $fields, $fields_to_be_updated, $values_to_be_updated);
        }
        echo '<script>
                window.location.href = window.location.pathname + "?view=admin-users";
              </script>';
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
            $adminUserController->editAdminUser($userId);
        } else {
            echo 'Invalid user ID';
        }
        break;

    case 'update':
        if ($userId) {
            $user_data = $adminUserController->editAdminUser($userId);
            $adminUserController->updateAdminUser($userId, $user_data);
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
