<?php

// require_once 'config/db_info.php';
// require_once 'db/db_class.php';
// require_once 'models/User.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
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

        $result = $db->paramsQuery($base_query, $params, null);
        $products = $result['data'];
        return $products;
    }

    public function getUsers()
    {
        $User = new User();
        $User->createUsersTable();

        $db = Database::getInstance();
        $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $base_query = "SELECT * FROM users";

        $params = [
            'page' => isset($_GET['page']) ? $_GET['page'] : 1,
            'limit' => isset($_GET['limit']) ? $_GET['limit'] : 10,
            'order' => isset($_GET['order']) ? $_GET['order'] : null,
            'search' => isset($_GET['search']) ? $_GET['search'] : null,
        ];

        $result = $db->paramsQuery($base_query, $params, null);
        $users = $result['data'];
        return $users;
    }

    public function showHome($products, $users)
    {
        include 'views/admin/admin_home_view.php';
    }
}

if (isset($_POST['user_selected'])) {
    $_SESSION['user_selected_id'] = $_POST['user_selected'];
}

if (isset($_GET['product'])) {
    $db = Database::getInstance();
    $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $db_products = $db->select('products');
    $db_product = array_values(array_filter($db_products, fn ($obj) => $obj['id'] == $_GET['product']));

    function objectExists($array, $object)
    {
        foreach ($array as $item) {
            if ($item['id'] == $object['id']) {
                return true;
            }
        }
        return false;
    }

    $drink = $db_product[0];
    $drink['quantity'] = 1;

    if (!objectExists($_SESSION['cart'], $drink)) {
        $_SESSION['cart'][] = $drink;
    }
}

if (isset($_POST['remove_product'])) {
    $productId = $_POST['remove_product'];
    $db_products = array_values(array_filter($_SESSION['cart'], fn ($obj) => $obj['id'] != $productId));
    $_SESSION['cart'] = $db_products;
}

if (isset($_POST['change_count'])) {
    $data = $_POST['change_count'];
    $data = explode(" ", $data);

    $productId = $data[0];
    $productQuantity = $data[1];

    if ($productQuantity >= 1) {
        $index = array_search($productId, array_column($_SESSION['cart'], 'id'));
        if ($index !== false) {
            $_SESSION['cart'][$index]['quantity'] = $productQuantity;
        }
    }
}

if (isset($_POST['order_cart'])) {
    unset($_POST['order_cart']);

    $queryString = http_build_query($_POST);
    $queryString = urlencode($queryString);

    header("Location: orders.php?$queryString");
}

$adminHomeController = new AdminHomeController();
$products = $adminHomeController->getProducts();
$users = $adminHomeController->getUsers();

$adminHomeController->showHome($products, $users);
