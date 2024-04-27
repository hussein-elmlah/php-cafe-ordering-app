<?php

require_once 'config/db_info.php';
require_once 'models/User.php';
require_once 'models/orders.php';
//require_once  'models/products.php';
require_once 'models/order_items.php';
include 'includes/pagination.php';

class UserOrdersController
{
    function add_order()
    {
        session_start();
        $db = Database::getInstance();
        $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $total_amount = isset($_GET['total_amount']) ? $_GET['total_amount'] : null;
        $total_price = isset($_GET['total_price']) ? $_GET['total_price'] : null;
        $room = isset($_GET['room']) ? $_GET['room'] : '';
        $user_email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    
        // Enclose string values in quotes
        $total_amount = is_numeric($total_amount) ? $total_amount : "'$total_amount'";
        $total_price = is_numeric($total_price) ? $total_price : "'$total_price'";
        $room = "'$room'";
        $user_email = "'$user_email'";

        $columns = "total_amount, total_price, room, user_email";
        $values = "$total_amount, $total_price, $room, $user_email";

        // Perform the insert operation
        $order = $db->insert('orders', $columns, $values);
        if($order){
            $lastInserted = $db->customQuery("SELECT LAST_INSERT_ID()");
            $order_id = $lastInserted[0]["LAST_INSERT_ID()"];
            var_dump($order_id);
            $item_columns = implode(',',array('quantity', 'order_id', 'product_id'));
            $products = isset($_GET['products']) ? $_GET['products'] :[];
            foreach ($products as $product) {
                $quantity = isset($_GET['quantity']) ? $_GET['quantity'] :null;
                $item_values =  implode(',', array($quantity, $order_id, $product));
                $item = $db->insert('order_items', $item_columns, $item_values);
            }
        }else{
            echo "<p class='text-danger'>failed to request order</p>";
        }
    }
    function edit_order()
    {
    }
    function cancel_order()
    {
    }
    function get_orders()
    {
        session_start();
        $db = Database::getInstance();
        $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $user_email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

    }
    function filtered_orders()
    {
    }
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$userId = isset($_GET['user_id']) ? $_GET['user_id'] : null;

$UserOrders = new UserOrdersController();

switch ($action) {
    case 'edit':
        if ($userId) {
            $UserOrders->edit_order();
        } else {
            echo 'Invalid user ID';
        }
        break;
    case 'delete':
        if ($userId) {
            $UserOrders->cancel_order();
        } else {
            echo 'Invalid user ID';
        }
        break;
    default:
        $UserOrders->get_orders();
        break;
}
