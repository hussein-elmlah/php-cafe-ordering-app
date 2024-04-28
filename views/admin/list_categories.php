<?php
require_once 'controllers/category_controller.php';
$categoryModel = new categoryModel();
$categories = $categoryModel->getAllCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Categories</title>
</head>
<body>
    <h1>List Categories</h1>
    <!-- <a href="add_category.php"><button>Add Category</button></a> -->
    <ul>
        <?php foreach($categories as $category): ?>
            <li><?php echo $category['name']; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
