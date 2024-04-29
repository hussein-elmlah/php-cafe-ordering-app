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
    function cancel_order()
    {
        $db = Database::getInstance();
        $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;
        $db->delete('orders',$order_id);
        include './views/user/orders/cancel_order_view.php';
    }
    function get_orders()
    {
        $db = Database::getInstance();
        $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $user_email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
        $current_page = 1;
        $total_pages = 2;

        $base_query = "SELECT * FROM orders WHERE user_email = '$user_email'";
        $params = [
            'page' => isset($_GET['page']) ? $_GET['page'] : 1,
            'limit' => isset($_GET['limit']) ? $_GET['limit'] : 2,
            'order' => isset($_GET['order']) ? $_GET['order'] : null,
            'search' => isset($_GET['search']) ? $_GET['search'] : null,
        ];

        $search_fields = ['user_email'];

        $result = $db->paramsQuery($base_query, $params, $search_fields);
        $orders = $result['data'];
        $current_page = $result['current_page'];
        $total_pages = $result['total_pages'];

        include './views/user/orders/display_orders_view.php';

        Pagination($current_page, $total_pages);
    }
    public function display_user_order_details()
    {
        $current_page = 1;
        $total_pages = 2;

        $db = Database::getInstance();
        $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $base_query = "SELECT * FROM order_items WHERE order_id = '{$_GET['order_id']}'";

        $params = [
            'page' => isset($_GET['page']) ? $_GET['page'] : 1,
            'limit' => isset($_GET['limit']) ? $_GET['limit'] : 5,
            'order' => isset($_GET['order']) ? $_GET['order'] : null,
            'search' => isset($_GET['search']) ? $_GET['search'] : null,
        ];

        // var_dump( $params);

        $search_fields = ['name', 'name'];

        $result = $db->paramsQuery($base_query, $params, $search_fields);
        $items = $result['data'];
        $current_page = $result['current_page'];
        $total_pages = $result['total_pages'];
        
        include './views/user/orders/order_details_view.php';

        Pagination($current_page, $total_pages);
    }
    function getProduct($product_id) {
        $db = Database::getInstance();
        $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $query = "SELECT * FROM products WHERE id = '$product_id' ";
        return $db->customQuery($query);
    }

    function get_orders_by_date()
    {
        $db = Database::getInstance();
        $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (isset($_GET['user_email'])) {
            $user_email = $_GET['user_email'];
            if (isset($_GET['date_to']) && isset($_GET['date_from'])) {
                $date_to = $_GET['date_to'];
                $date_from = $_GET['date_from'];
                $base_query = "SELECT * FROM orders WHERE created_date BETWEEN '$date_from' AND '$date_to' AND user_email = '$user_email'";
            } elseif (isset($_GET['date_from'])) {
                $date_from = $_GET['date_from'];
                $base_query = "SELECT * FROM orders where created_date > '$date_from' AND user_email = '$user_email' ";
            } elseif (isset($_GET['date_to'])) {
                $date_to = $_GET['date_to'];
                $base_query = "SELECT * FROM orders where created_date < '$date_to' AND user_email = '$user_email' ";
            } else {
                $base_query = "SELECT * FROM orders where user_email = '$user_email'";
            }
        } elseif (isset($_GET['date_to']) && isset($_GET['date_from'])) {
            $date_to = $_GET['date_to'];
            $date_from = $_GET['date_from'];
            $base_query = "SELECT * FROM orders WHERE created_date BETWEEN '$date_from' AND '$date_to' ";
        } elseif (isset($_GET['date_from'])) {
            $date_from = $_GET['date_from'];
            $base_query = "SELECT * FROM orders where created_date > '$date_from'";
        } elseif (isset($_GET['date_to'])) {
            $date_to = $_GET['date_to'];
            $base_query = "SELECT * FROM orders where created_date < '$date_to' ";
        } else {
            $base_query = "SELECT * FROM orders";
        }

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
        include './views/user/orders/display_orders_view.php';
        Pagination($current_page, $total_pages);
    }
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;

$UserOrders = new UserOrdersController();

switch ($action) {
    case 'delete':
        if ($order_id) {
            $UserOrders->cancel_order();
        } else {
            echo 'Invalid order ID';
        }
        break;
    case 'details':
        if ($order_id) {
            $UserOrders->display_user_order_details();
        } else {
            echo 'Invalid order ID';
        }
        break;
        case 'date':
                $UserOrders->get_orders_by_date();
            break;
    default:
        $UserOrders->get_orders();
        break;
}
