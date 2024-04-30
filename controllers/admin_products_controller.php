<?php

require_once 'db/db_class.php'; 
require_once 'models/ProductModel.php';
include 'includes/pagination.php';
require_once 'utilities/uploadImage.php';

// Initialize variables 
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
            $sql = "SELECT * FROM categories"; 
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $categories;
        } catch (PDOException $e) {
            return []; 
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

       
        $sql = "INSERT INTO products (name, image, description, price, category_id) VALUES (:name, :image, :description, :price, :category_id)";
        $stmt =  $this->db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $result = $stmt->execute();
        return $result; 
    } catch (PDOException $e) {
        return false; 
    }
}

// Method to update a product
public function updateProduct($id, $name, $price, $image , $category_id) {
    try {
        $image_path = '';

        if (!empty($image['tmp_name'])) {
            $imageUploadResult = handleImageUpload($image);
            if (isset($imageUploadResult['error'])) {
                return false;
            }
            $image_path = $imageUploadResult['image'];
        }

        
        $sql = "UPDATE products SET name = :name, price = :price,  image = :image, category_id = :category WHERE id = :id";
      
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':category', $category_id);
        
        if (!empty($image_path)) {
            $stmt->bindParam(':image', $image_path);
        }

        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return true; 
    } catch (PDOException $e) {
        return false; 
    }
}
}


$productController = new ProductController();

// Handle form submission for updating product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["product_id"])) {
    $id = $_POST["product_id"];

    // Check if all required form fields are set
    if (isset($_POST["product_name"], $_POST["product_price"])) {
        $name = $_POST["product_name"];
        $price = $_POST["product_price"];
        $category_id = $_POST["category"];

        // Check if an image was uploaded
        $image_path = '';
        if (isset($_FILES["image"])) {
            
            $imageUploadResult = handleImageUpload($_FILES["image"]);
            var_dump($imageUploadResult);
            var_dump($image_path);
            if (isset($imageUploadResult['error'])) {
               
                $error = $imageUploadResult['error'];
            } else {
               
                $image_path = $imageUploadResult['image'];
            }
        }

        if (empty($error)) {

            $updateResult = $productController->updateProduct($id, $name, $price, $image_path, $category_id);

            if ($updateResult) {
               
                $success_message = "Product updated successfully.";
            } else {
                
                $error = "Error updating product.";
            }
        }
    } else {
        $error = "Required form fields are missing.";
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST["name"], $_POST["description"], $_POST["price"], $_POST["category"], $_FILES["image"])) {
        $name = $_POST["name"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $category_id = $_POST["category"];

        // Handle image upload
        $image_path = ''; 
        $imageUploadResult = uploadImage($_FILES, []);
        if (isset($imageUploadResult['data']['image'])) {
            $image_path = $imageUploadResult['data']['image']; // Get uploaded image path
        } else {
            
            echo json_encode(array('status' => 'error', 'message' => $imageUploadResult['errors']['image']));
            exit;
        }

        // Add product to the database
        $result = $productController->addProduct($name, $image_path, $description, $price, $category_id);
        if ($result) {
           
            $success_message = 'Product added successfully.';
        } else {
            
            $error = 'A product with the same name already exists.';
        }

    } else {
       
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

    

include 'views/admin/add_product.php';
Pagination($current_page, $total_pages);
?>
