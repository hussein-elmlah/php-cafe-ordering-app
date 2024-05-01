<?php

class CategoryController {
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
        
        $db = Database::getInstance();
        $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $base_query = "SELECT * FROM categories";

        $params = [
            'page' => isset($_GET['page']) ? $_GET['page'] : 1,
            'limit' => isset($_GET['limit']) ? $_GET['limit'] : 3,
            'order' => isset($_GET['order']) ? $_GET['order'] : null,
            'search' => isset($_GET['search']) ? $_GET['search'] : null,
        ];


        $search_fields = ['name', 'name'];
    
        $result = $db->paramsQuery($base_query, $params, $search_fields);
        return $result;
    }

}

    // Temporary placeholder values
    $isLoggedIn = @$_SESSION['is_auth'];
    $loggedUser = array(
        'isAdmin' => @$_SESSION['is_admin'],
        'first_name' => @$_SESSION['user_name']
    );

    $current_page = 1;
    $total_pages = 2; 

// Initialize variables to hold form data and error messages
$name = $error = '';
$success_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    if (empty($_POST["name"])) {
        $error = "Category name is required";
    } else {
        $name = $_POST["name"];
        
        // Check if an image was uploaded
        // if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        //     $image_tmp = $_FILES["image"]["tmp_name"];
        //     $upload_dir = "public/images/"; // Specify the directory where you want to store the uploaded images
        //     $image_path = $upload_dir . basename($_FILES["image"]["name"]); // Construct the image path
        //     move_uploaded_file($image_tmp, $image_path); // Move the uploaded image to the specified directory
        // } else {
        //     $image_path = null; // If no image was uploaded, set the image path to null
        // }

        $data = ['lastImage' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/832px-No-Image-Placeholder.svg.png'];
        $imageUploadResult = uploadImage($_FILES, $data);
        $old_data = $imageUploadResult['data'];
        // var_dump($imageUploadResult);
        $image_path = $old_data['image'];

        // Create an instance of CategoryController and add the category
        $category = new CategoryController();
        $result = $category->addCategory($name, $image_path); // Pass $image_path instead of $image
        
        if ($result) {
            // Set success message
            $success_message = "Category '$name' added successfully.";
            // Clear the name field for a new entry
            $name = '';
        } else {
            $error = "Failed to add category";
        }
    }
}

// Fetch all categories to display
$categoryController = new CategoryController();
$result = $categoryController->getAllCategories();
$categories = $result['data'];
$current_page = $result['current_page'];
$total_pages = $result['total_pages'];

include "views/admin/add_category.php";
Pagination($current_page, $total_pages);

?>
