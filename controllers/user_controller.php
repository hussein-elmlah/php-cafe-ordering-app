<?php

require_once 'vendor/autoload.php';
use Respect\Validation\Validator as DataValidation;
use Respect\Validation\Exceptions\ValidationException;

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
            $_SESSION['old_email'] = $email;
            $_SESSION['old_password'] = $password;
            echo '<script> 
            window.location.href = window.location.pathname + "?view=login";
            </script>';
        }
    }

    public function viewLoginForm()
    {
        include 'views/user/user_login_view.php';
    }

    public function viewRegisterForm()
    {
        $roomQuery = "SELECT * FROM rooms";
        $rooms = $this->db->customQuery($roomQuery);
        include 'views/user/user_register_view.php';
    }

    public function register()
    {

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
            $this->db->insert_with_data(
                "users",
                "name,email,password,room,ext,profile",
                ":name,:email,:password,:room,:ext,:profile",
                $_POST
            );
            $_SESSION['msg'] = "Your account is saved successfully";
             echo '<script> 
                window.location.href = window.location.pathname;
              </script>';
        } catch (ValidationException $exception) {
            $_SESSION['error'] = $exception->getMessage();
             echo '<script> 
                window.location.href = window.location.pathname + "?view=register&action=register";
              </script>';
        }

       
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
    
    case 'register':
        $user->viewRegisterForm();
        break;

    case 'store':
        $user->register();
        break;

    default:
        $user->viewLoginForm();
        break;
}
