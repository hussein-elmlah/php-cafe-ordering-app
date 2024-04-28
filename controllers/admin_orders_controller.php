<?php

require_once 'config/db_info.php';
require_once 'models/User.php';
require_once 'models/orders.php';
//require_once  'models/products.php';
require_once 'models/order_items.php';
include 'includes/pagination.php';
class AdminOrdersController
{
    public function displayAdminOrders()
    {

        $current_page = 1;
        $total_pages = 2;

        $db = Database::getInstance();
        $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $base_query = "SELECT * FROM orders";

        $params = [
            'page' => isset($_GET['page']) ? $_GET['page'] : 1,
            'limit' => isset($_GET['limit']) ? $_GET['limit'] : 5,
            'order' => isset($_GET['order']) ? $_GET['order'] : null,
            'search' => isset($_GET['search']) ? $_GET['search'] : null,
        ];

        // var_dump( $params);

        $search_fields = ['name', 'name'];

        $result = $db->paramsQuery($base_query, $params, $search_fields);
        $orders = $result['data'];
        $current_page = $result['current_page'];
        $total_pages = $result['total_pages'];

        include './views/admin/orders/display_orders_view.php';

        Pagination($current_page, $total_pages);
    }
    public function displayAdminOrderDetails()
    {

        $current_page = 1;
        $total_pages = 3;

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
        include './views/admin/orders/display_order_details_view.php';

        Pagination($current_page, $total_pages);
    }
    public function editOrederStatus($order_id, $new_status)
    {
        $db = Database::getInstance();
        $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $fields = "status = :status"; 
        $keys = "status"; 
        $values = [$new_status]; 
        $query = $db->update('orders', $order_id, $fields, $keys, $values);
        if($query !== false) {
            include './views/admin/orders/edit_order_view.php';
        } else {
            echo "<p class='text-danger'> Faild to update </p>";
        }
        
    }
    function cancel_order()
    {
        session_start();
        $db = Database::getInstance();
        $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;
        $db->delete('orders',$order_id);
        include './views/admin/orders/edit_order_view.php';
    }

    function getProduct($product_id) {
        $db = Database::getInstance();
        $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $query = "SELECT * FROM products WHERE id = '$product_id' ";
        return $db->customQuery($query);
    }
   
}
$action = isset($_GET['action']) ? $_GET['action'] : '';
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;

$admin_orders = new AdminOrdersController();

switch ($action) {
     case 'edit':
        if ($order_id) {
            $new_status = isset($_GET['status']) ? $_GET['status'] :'';
            $admin_orders->editOrederStatus($order_id,$new_status);
        } else {
            echo 'Invalid order ID';
        }
        break; 
        case 'details':
            if ($order_id) {
                $admin_orders->displayAdminOrderDetails();
            } else {
                echo 'Invalid order ID';
            }
            break;
        case 'delete':
            if ($order_id) {
                $admin_orders->cancel_order();
            } else {
                echo 'Invalid user ID';
            }
            break;
    default:
        $admin_orders->displayAdminOrders();
        break;
}
