<?php

require_once './db/db_class.php';
require_once './config/db_info.php';
require_once 'includes/pagination.php';

class Product
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    }

    function createProductsTable()
    {
        try {
            $query = "CREATE TABLE IF NOT EXISTS products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                quantity INT NOT NULL,
                price INT NOT NULL
            )";

            $this->db->customQuery($query);
        } catch (PDOException $e) {
            die("Error creating products table: " . $e->getMessage());
        }
    }

    public function getProducts()
    {
        $base_query = "SELECT * FROM products";

        $params = [
            'page' => isset($_GET['page']) ? $_GET['page'] : 1,
            'limit' => isset($_GET['limit']) ? $_GET['limit'] : 10,
            'order' => isset($_GET['order']) ? $_GET['order'] : null,
            'search' => isset($_GET['search']) ? $_GET['search'] : null,
        ];

        // $search_fields = ['name', 'name'];

        $result = $this->db->paramsQuery($base_query, $params, null);
        var_dump($result["data"]);
    }
}

$Product = new Product();
$Product->createProductsTable();
