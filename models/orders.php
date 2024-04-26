<?php

require_once './db/db_class.php';
require_once './config/db_info.php';

class Order{

    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
       
    }

    function createOrdersTable(){
        $date = date('Y-m-d H:i:s');
        try {
            $query = "CREATE TABLE IF NOT EXISTS orders (
                order_id INT AUTO_INCREMENT PRIMARY KEY,
                created_date DATE NOT NULL DEFAULT '$date',
                total_amount INT NOT NULL,
                status ENUM('Processing', 'Out for delivery', 'Done') NOT NULL DEFAULT 'Processing',
                room VARCHAR(255) NOT NULL,
                total_price int NOT NULL,
                user_email VARCHAR(255) NOT NULL,
                CONSTRAINT fk_user
                FOREIGN KEY (user_email)
                REFERENCES users(email)
                ON DELETE CASCADE
            )";

        $this->db->customQuery($query);

        } catch (PDOException $e) {
            die("Error creating users table: " . $e->getMessage());
        }
    }
}

$order = new Order();
$order->createOrdersTable();  

?>