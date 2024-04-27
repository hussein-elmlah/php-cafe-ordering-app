<?php
require_once 'controllers/category_controller.php';
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
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
            $image_tmp = $_FILES["image"]["tmp_name"];
            $upload_dir = "public/images/"; // Specify the directory where you want to store the uploaded images
            $image_path = $upload_dir . basename($_FILES["image"]["name"]); // Construct the image path
            move_uploaded_file($image_tmp, $image_path); // Move the uploaded image to the specified directory
        } else {
            $image_path = null; // If no image was uploaded, set the image path to null
        }

        // Create an instance of CategoryController and add the category
        $categoryModel = new CategoryModel();
        $result = $categoryModel->addCategory($name, $image_path); // Pass $image_path instead of $image
        
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
$categoryModel = new CategoryModel();
$categories = $categoryModel->getAllCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category List</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            max-height: 200px; /* Set maximum height for category images */
            object-fit: cover; /* Ensure the image covers the entire card */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Add Category</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Category Name:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $name; ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Category Image:</label>
                <input type="file" name="image" id="image" class="form-control-file" accept="image/*"> <!-- Add input field for image -->
            </div>
            <button type="submit" class="btn btn-primary">Add Category</button>
            <!-- Display error message if any -->
            <span style="color: red;"><?php echo $error; ?></span>
            <!-- Display success message if any -->
            <span style="color: green;"><?php echo $success_message; ?></span>
        </form>
        
        <h1>Categories List</h1>
        <div class="row">
            <?php if (!empty($categories)) : ?>
                <?php foreach ($categories as $category) : ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <?php if (!empty($category['image'])) : ?>
                                <img src="<?php echo $category['image']; ?>" class="card-img-top" alt="<?php echo $category['name']; ?>">
                            <?php else: ?>
                                <img src="placeholder.jpg" class="card-img-top" alt="Placeholder">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $category['name']; ?></h5>
                                <!-- Add any additional category details here -->
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col">
                    <p>No categories found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
