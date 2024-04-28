<?php if ($loggedUser['isAdmin']): ?>
<div class="container mt-5">
    <h1>Add Product</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <!-- Form fields for adding a product -->
        <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <select name="category" id="category" class="form-control" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>
        <div class="form-group">
            <label for="image">Product Image:</label>
            <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
        </div>
        <br>

        <button type="submit" class="btn btn-primary">Add Product</button>
        <!-- Display error and success messages -->
        <span style="color: red;"><?php echo $error; ?></span>
        <span style="color: green;"><?php echo $success_message; ?></span>
    </form>
</div>
<?php endif; ?>

<div class="container mt-5">
    <h1>List of Products</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($products as $product): ?>
            <div class="col">
                <div class="card h-100">
                    <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="Product Image">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo $product['name']; ?></h5>
                        <p class="card-text"><?php echo $product['description']; ?></p>
                        <p class="card-text">Price: <?php echo $product['price']; ?> <span>EG</span></p>
                        <!-- Add any additional content here -->
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<br>
<br>
