<?php
require_once 'config/db_info.php';
include 'includes/pagination.php';
require('./db/db_class.php');
class ChecksController
{
    function get_orders_checks_user()
    {
        $users = $this->get_users();
        $orders = $this->get_orders_by_date();
        $db = Database::getInstance();
        $current_page = 1;
        $total_pages = 2;

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

        $orders_users = $result['data'];
        $current_page = $result['current_page'];
        $total_pages = $result['total_pages'];

        include './views/admin/orders/display_checks_view.php';
        Pagination($current_page, $total_pages);
    }
    function get_orders_by_date()
    {
        $users = $this->get_users();
        $db = Database::getInstance();
        $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $orders_users = $db->select('orders');
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

        return $orders;
    }
    function get_users()
    {
        $db = Database::getInstance();
        $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $users = $db->select('users');
        return $users;
    }
}
$check = new ChecksController();
$check->get_orders_checks_user();
