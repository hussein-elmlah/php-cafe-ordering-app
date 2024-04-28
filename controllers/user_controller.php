<?php

require_once 'config/db_info.php';
require_once 'db/db_class.php';

class UserController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    }

    public function loginUser()
    {
        [
            'email' => $email,
            'password' => $password,
        ] = $_POST;

        $loggedInUserData = $this->db->customQuery("SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1");

        if (count($loggedInUserData) > 0) {
            $_SESSION['is_auth'] = true;
            $_SESSION['is_admin'] = $loggedInUserData[0]['is_admin'];
            $_SESSION['user_name'] = $loggedInUserData[0]['name'];
            if ($loggedInUserData[0]['is_admin'] === 1) {
                echo '<script> 
                window.location.href = window.location.pathname + "?view=admin-users";
                </script>';
            } else {
                $baseHref = rtrim(dirname($_SERVER['PHP_SELF']), '/');
                $url = "http://$_SERVER[HTTP_HOST]$baseHref/";
                echo "<script>window.location.href = '$url';</script>";
            }
        } else {
            $_SESSION['is_auth'] = false;
            $_SESSION['error'] = "Bad Credentials";
            echo '<script> 
            window.location.href = window.location.pathname + "?view=login";
            </script>';
        }
    }

    public function viewLoginForm()
    {
        include 'views/user/user_login_view.php';
    }
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$userId = isset($_GET['user_id']) ? $_GET['user_id'] : null;
$data = isset($_GET['data']) ? $_GET['data'] : null;

$user = new UserController();

switch ($action) {

    case 'validate':
        $user->loginUser();
        break;
    default:
        $user->viewLoginForm();
        break;
}
