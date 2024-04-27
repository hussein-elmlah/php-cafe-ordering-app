<?php
require_once 'config/db_info.php';
require_once 'db/db_class.php';

class CategoryModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    }
    public function addCategory($name, $image_path) {
        try {
            // Check if the category already exists
            $query = "SELECT COUNT(*) AS count FROM categories WHERE name = :name";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':name', $name, PDO::PARAM_STR);
            $statement->execute();
            $count = $statement->fetch(PDO::FETCH_ASSOC)['count'];
            
            if ($count > 0) {
                return false; // Category already exists
            }
            
            // Add the category if it doesn't exist
            $query = "INSERT INTO categories (name, image) VALUES (:name, :image_path)";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':name', $name, PDO::PARAM_STR);
            $statement->bindParam(':image_path', $image_path, PDO::PARAM_STR);
            $result = $statement->execute();
            
            return $result;
        } catch (PDOException $e) {
            echo "Error adding category: " . $e->getMessage();
            return false;
        }
    }
    
    

    public function getAllCategories() {
        try {
            $query = "SELECT * FROM categories";
            $statement = $this->db->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error getting all categories: " . $e->getMessage();
            return false;
        }
    }

    
}

?>
