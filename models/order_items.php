<?php

require_once 'db/db_class.php';
require_once 'config/db_info.php';

class OrderItem{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    }

    function createOrderItemsTable(){
        try {
            $query = "CREATE TABLE IF NOT EXISTS order_items (
                quantity INT NOT NULL,
                order_id INT NOT NULL,
                product_id INT NOT NULL,
                PRIMARY KEY (order_id,product_id),
                CONSTRAINT fk_order
                FOREIGN KEY (order_id)
                REFERENCES orders(id)
                ON DELETE CASCADE,
                CONSTRAINT fk_product
                FOREIGN KEY (product_id)
                REFERENCES products(id)
                ON DELETE CASCADE
            )";

        $this->db->customQuery($query);

        } catch (PDOException $e) {
            die("Error creating users table: " . $e->getMessage());
        }
    }
}

$items = new OrderItem();
$items->createOrderItemsTable(); 

