<?php

require_once './db/db_class.php'; 
require_once './config/db_info.php'; 

class Category {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    }

    public function createCategoriesTable() {
        try {
            $query = "CREATE TABLE IF NOT EXISTS categories (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(255) NOT NULL,
                        image VARCHAR(255)
                      )";

            $this->db->customQuery($query);
              // Temporary placeholder values
              $isLoggedIn = true;
              $loggedUser = array(
                  'isAdmin' => false,
                  'first_name' => 'Hussein'
              );
          if ($isLoggedIn && $loggedUser['isAdmin']) {
             echo "Categories table created successfully.";
          }
        } catch (PDOException $e) {
            // Log the error or provide meaningful feedback to the user
            echo "Error creating categories table: " . $e->getMessage();
        }
    }
}

$category = new Category();
$category->createCategoriesTable();
?>
