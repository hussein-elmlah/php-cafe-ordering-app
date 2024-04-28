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
        if ($order) {
            $lastInserted = $db->customQuery("SELECT LAST_INSERT_ID()");
            $order_id = $lastInserted[0]["LAST_INSERT_ID()"];
            $item_columns = implode(',', array('quantity', 'order_id', 'product_id'));
            $products = isset($_GET['products']) ? $_GET['products'] : [];
            foreach ($products as $product) {
                $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : null;
                $item_values =  implode(',', array($quantity, $order_id, $product));
                $item = $db->insert('order_items', $item_columns, $item_values);
            }
        } else {
            echo "<p class='text-danger'>failed to request order</p>";
        }
    }
   /*  function edit_order($order_id,$new_status)
    {
            $db = Database::getInstance();
            $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $fields = "`status` = :$new_status";
            $query = $db->update('orders',$order_id,$fields);
            if($query === false) {
                include 'all_orders_view.php';
            } else {
                echo "<p class='text-danger'> Faild to update </p>";
            }
        } */
    function cancel_order()
    {
        session_start();
        $db = Database::getInstance();
        $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;
        $db->delete('orders',$order_id);
        include './views/user/orders/cancel_order_view.php';
    }
    function get_orders()
    {
        session_start();
        $db = Database::getInstance();
        $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $user_email = isset($_SESSION['email']) ? $_SESSION['email'] : 'john@example.com';

        $current_page = 1;
        $total_pages = 2;

        $db = Database::getInstance();
        $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $base_query = "SELECT * FROM orders";

        $params = [
            'page' => isset($_GET['page']) ? $_GET['page'] : 1,
            'limit' => isset($_GET['limit']) ? $_GET['limit'] : 2,
            'order' => isset($_GET['order']) ? $_GET['order'] : null,
            'search' => isset($_GET['search']) ? $_GET['search'] : null,
        ];

        // var_dump( $params);

        $search_fields = ['user_email'];

        $result = $db->paramsQuery($base_query, $params, $search_fields);

        $orders = $result['data'];
        $current_page = $result['current_page'];
        $total_pages = $result['total_pages'];

        include './views/user/display_orders_view.php';

        Pagination($current_page, $total_pages);
    }
    function filtered_orders()
    {
    }
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$order_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;

$UserOrders = new UserOrdersController();

switch ($action) {
    case 'edit':
        if ($order_id) {
            $order_status = isset($_GET['status']) ? $_GET['status'] :'';
            $UserOrders->edit_order($order_id,$new_status);
        } else {
            echo 'Invalid user ID';
        }
        break;
    case 'delete':
        if ($order_id) {
            $UserOrders->cancel_order();
        } else {
            echo 'Invalid user ID';
        }
        break;
    default:
        $UserOrders->get_orders();
        break;
}
