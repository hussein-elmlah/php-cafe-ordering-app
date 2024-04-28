<?php

require_once './db/db_class.php';
require_once 'config/db_info.php';
require_once 'db/db_class.php';

// session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

class Admin
{
    public $id;
    public $name;
    public $email;

    public function __construct($id, $name, $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }
}

class Product
{
    public $name;
    public $quantity;
    public $price;

    public function __construct($name, $quantity, $price)
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    public function getTotalPrice()
    {
        return $this->quantity * $this->price;
    }
}

class AdminHomeController
{
    public function getProducts()
    {
        $db = Database::getInstance();
        $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $base_query = "SELECT * FROM products";

        $params = [
            'page' => isset($_GET['page']) ? $_GET['page'] : 1,
            'limit' => isset($_GET['limit']) ? $_GET['limit'] : 10,
            'order' => isset($_GET['order']) ? $_GET['order'] : null,
            'search' => isset($_GET['search']) ? $_GET['search'] : null,
        ];

        // $search_fields = ['name', 'name'];

        $result = $db->paramsQuery($base_query, $params, null);
        $products = $result['data'];
        return $products;
    }

    public function showHome($products)
    {
        include 'views/admin/admin_home_view.php';
    }

    public function deleteAdmin($userId)
    {
        include 'delete_admin_user_confirmation_view.php';
    }
}

$adminHomeController = new AdminHomeController();

$adminHomeController->showHome($adminHomeController->getProducts());
$adminHomeController->getProducts();
