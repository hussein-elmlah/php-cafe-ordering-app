<?php

require_once 'config/db_info.php';
require_once 'models/User.php';
require_once 'models/orders.php';
//require_once  'models/products.php';
require_once 'models/order_items.php';
include 'includes/pagination.php';
class AdminOrders
{
    public $order_id;
    public $user_email;
    public $status;
    public $created_date;
    public $room;
    public $total_price;
    public function __construct($order_id,$user_email,$status, $room, $created_date,$total_price)
    {
     $this->order_id = $order_id;
     $this->user_email = $user_email;
     $this->status = $status;
     $this->room = $room;
     $this->total_price = $total_price;
     $this->created_date = $created_date;

    }
}
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
            'limit' => isset($_GET['limit']) ? $_GET['limit'] : 2,
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
    public function editOrederStatus($order_id, $new_status)
    {
        $db = Database::getInstance();
        $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $fields = "`status` = :new_status";
        $query = $db->update('orders',$order_id,$fields);
        if($query === false) {
            include 'all_orders_view.php';
        } else {
            echo "<p class='text-danger'> Faild to update </p>";
        }
    }
}
$action = isset($_GET['action']) ? $_GET['action'] : '';
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;

$admin_orders = new AdminOrdersController();

switch ($action) {
    case 'edit':
        if ($order_id) {
            $order_status = isset($_GET['status']) ? $_GET['status'] :'';
            $admin_orders->editOrederStatus($order_id,$new_status);
        } else {
            echo 'Invalid order ID';
        }
        break;
    default:
        $admin_orders->displayAdminOrders();
        break;
}
