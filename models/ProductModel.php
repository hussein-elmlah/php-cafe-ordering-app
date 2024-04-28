<?php

require_once './db/db_class.php'; 
require_once './config/db_info.php'; 

class Product {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    }

    public function createProductsTable() {
        try {
            $query = "CREATE TABLE IF NOT EXISTS products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                image VARCHAR(255),
                description TEXT,
                price DECIMAL(10, 2) NOT NULL,
                category_id INT,
                FOREIGN KEY (category_id) REFERENCES categories(id)
            )";

            $this->db->customQuery($query);
            echo "Products table created successfully.";
        } catch (PDOException $e) {
            // Log the error or provide meaningful feedback to the user
            echo "Error creating Products table: " . $e->getMessage();
        }
    }
}

$product = new Product();
$product->createProductsTable();
?>
