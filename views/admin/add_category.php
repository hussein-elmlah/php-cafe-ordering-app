<div class="container mt-5">
    <?php if ($loggedUser['isAdmin']): ?>
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
    <?php endif; ?>
    <h1>Categories List</h1>
    <div class="row">
        <?php if (!empty($categories)) : ?>
            <?php foreach ($categories as $category) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100"> <!-- Ensure all cards have the same height -->
                        <?php if (!empty($category['image'])) : ?>
                            <img src="<?php echo $category['image']; ?>" class="card-img-top img-fluid h-100" alt="<?php echo $category['name']; ?>"> <!-- Add img-fluid class for responsive images -->
                        <?php else: ?>
                            <img src="placeholder.jpg" class="card-img-top img-fluid" alt="Placeholder"> <!-- Add img-fluid class for responsive images -->
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
