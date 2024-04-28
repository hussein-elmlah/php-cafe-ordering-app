<?php

require_once 'db/db_class.php'; 
require_once 'models/ProductModel.php';
include 'includes/pagination.php';
require_once 'utilities/uploadImage.php';

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
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $categories;
        } catch (PDOException $e) {
            return []; // Return empty array on failure
        }
    }

   // Method to add a product
public function addProduct($name, $image, $description, $price, $category_id) {
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
        $sql = "INSERT INTO products (name, image, description, price, category_id) VALUES (:name, :image, :description, :price, :category_id)";
        $stmt =  $this->db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':image', $image);
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required form fields are set
    if (isset($_POST["name"], $_POST["description"], $_POST["price"], $_POST["category"], $_FILES["image"])) {
        $name = $_POST["name"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $category_id = $_POST["category"];

        // Handle image upload
        $image_path = ''; // Initialize image path
        $imageUploadResult = uploadImage($_FILES, []);
        if (isset($imageUploadResult['data']['image'])) {
            $image_path = $imageUploadResult['data']['image']; // Get uploaded image path
        } else {
            // Image upload failed
            echo json_encode(array('status' => 'error', 'message' => $imageUploadResult['errors']['image']));
            exit; // Stop further execution
        }

        // Add product to the database
        $result = $productController->addProduct($name, $image_path, $description, $price, $category_id);
        if ($result) {
            // Product added successfully
            $success_message = 'Product added successfully.';
        } else {
            // Product with the same name already exists
            $error = 'A product with the same name already exists.';
        }

    } else {
        // Required form fields are missing
        $error = 'Required form fields are missing.';
    }
}

// Fetch categories data
$categories = $productController->getAllCategories();

// Fetch products data
$result = $productController->getAllProducts();

// Fetch all products to display
$products = isset($result['data']) ? $result['data'] : [];
$current_page = isset($result['current_page']) ? $result['current_page'] : 1;
$total_pages = isset($result['total_pages']) ? $result['total_pages'] : 1;



    // Temporary placeholder values
    $isLoggedIn = @$_SESSION['is_auth'];
    $loggedUser = array(
        'isAdmin' => @$_SESSION['is_admin'],
        'first_name' => @$_SESSION['user_name']
    );

    if ($isLoggedIn && $loggedUser['isAdmin']) {
        echo "Products table created successfully.";
    }
// Include the view file
include 'views/admin/add_product.php';
Pagination($current_page, $total_pages);
?>
