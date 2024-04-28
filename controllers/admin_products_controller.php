<?php

require_once 'db/db_class.php'; 
require_once 'models/ProductModel.php';
include 'includes/pagination.php';

// Initialize variables to hold form data and error messages
$name = $error = '';
$success_message = '';
class ProductController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    }

    // Method to fetch all products
    public function getAllProducts() {
        $base_query = "SELECT * FROM products";

        $params = [
            'page' => isset($_GET['page']) ? $_GET['page'] : 1,
            'limit' => isset($_GET['limit']) ? $_GET['limit'] : 3,
            'order' => isset($_GET['order']) ? $_GET['order'] : null,
            'search' => isset($_GET['search']) ? $_GET['search'] : null,
        ];

        $search_fields = ['name', 'name'];
    
        return $this->db->paramsQuery($base_query, $params, $search_fields);
    }

    

    // Method to fetch all categories
    public function getAllCategories() {
        try {
           
            $sql = "SELECT * FROM categories"; // Assuming you have a table named 'categories'
            $stmt =  $this->db->prepare($sql);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $categories;
        } catch (PDOException $e) {
            return []; // Return empty array on failure
        }
    }

    // Method to add a product
    public function addProduct($name,$image, $description, $price, $category_id) {
        try {
            // Check if the product with the same name already exists
           
            $checkSql = "SELECT COUNT(*) FROM products WHERE name = :name";
            $checkStmt =  $this->db->prepare($checkSql);
            $checkStmt->bindParam(':name', $name);
            $checkStmt->execute();
            $count = $checkStmt->fetchColumn();
    
            if ($count > 0) {
                // Product with the same name already exists, return false
                return false;
            }
    
            // Insert the new product
            $sql = "INSERT INTO products (name, description, price, category_id) VALUES (:name, :description, :price, :category_id)";
            $stmt =  $this->db->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':category_id', $category_id);
            $result = $stmt->execute();
            return $result; // Return true on success, false on failure
        } catch (PDOException $e) {
            return false; // Return false on failure
        }
    }
}

// Create an instance of the ProductController class
$productController = new ProductController();

//upload images
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["name"])) {
        $name = $_POST["name"];
        $data = ['lastImage' => ''];
        $imageUploadResult = uploadImage($_FILES, $data);
        $image_path = $imageUploadResult['data']['image'];
        
        $result = $productController->addProduct($name,$image, $description, $price, $category_id);
        if ($result) {
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to add category'));
        }
    }
}
// Fetch categories data
$categories = $productController->getAllCategories();

// Fetch products data
$result = $productController->getAllProducts();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user is logged in and is admin
    if ($loggedUser['isAdmin']) {
        // Retrieve form data and process product addition
        // (Code for processing product addition remains the same as in your original code)
    } else {
        // User is not an admin
        $error = "You do not have permission to perform this action.";
    }
}

// Fetch all products to display
$products = isset($result['data']) ? $result['data'] : [];
$current_page = isset($result['current_page']) ? $result['current_page'] : 1;
$total_pages = isset($result['total_pages']) ? $result['total_pages'] : 1;

// Include the view file
include 'views/admin/add_product.php';
Pagination($current_page, $total_pages);
?>