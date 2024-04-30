
<?php if ($loggedUser['isAdmin']): ?>
    <?php 
$price = isset($_POST["price"]) ? $_POST["price"] : ''; 
?>
<div class="container mt-5">
    <h1>Add Product</h1><br>
    <form action="" method="post" enctype="multipart/form-data">
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

<!-- update_product_view -->
<div class="container mt-5">
    <h1>update Product</h1><br>
<form action="" method="post" enctype="multipart/form-data">
<div class="mb-3">
        <label for="id" class="product_id">Product Id:</label>
    <input type="number" name="product_id" value="<?php echo $id; ?>"required>
    </div>
    <div class="mb-3">
        <label for="name" class="form-label">Product Name:</label>
        <input type="text" name="product_name" value="<?php echo $name; ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Product Price:</label>
        <input type="number" name="product_price" value="<?php echo $price; ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Product Image:</label>
        <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
    </div>
    <div class="form-group">
            <label for="category">Category:</label>
            <select name="category" id="category" class="form-control" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    <button type="submit" class="btn btn-primary">Update Product</button>
</form>
    </div>
    <?php endif; ?>




<div class="container mt-5">
    <h1>List of Products</h1><br>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($products as $product): ?>
            <div class="col">
                <div class="card h-100">
                    <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="Product Image">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo $product['name']; ?></h5>
                        <p class="card-text"><?php echo $product['description']; ?></p>
                        <p class="card-text">Price: <?php echo $product['price']; ?> <span>EG</span></p>
                        <div class="mt-auto">
                        <button class="edit-product-button btn btn-primary" data-product-id="<?php echo $product['id']; ?>">ُEdit</button>
                            <button class="btn btn-danger btn-delete" data-product-id="<?php echo $product['id']; ?>">Delete</button>
                            <?php if (!$loggedUser['isAdmin']): ?>
                            <button class="btn btn-primary " >Add To Cart</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<br>
<br>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.min.js"></script>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button id="confirmDelete" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Delete button click handler
        $('.btn-delete').click(function() {
            var productId = $(this).data('product-id');
            // Display confirmation modal
            $('#confirmationModal').modal('show');

            // Handle confirmation
            $('#confirmDelete').click(function() {
                // Call the deleteProduct function
                deleteProduct(productId);
                $('#confirmationModal').modal('hide');
            });
        });

        // Function to delete the product
        function deleteProduct(productId) {
            // AJAX request to delete the product
            $.ajax({
                type: 'POST',
                url: '', 
                data: { id: productId },
                success: function(response) {
                    console.log(response);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });
</script>

   
<script>
    var editButtons = document.querySelectorAll('.edit-product-button');

    editButtons.forEach(function(button) {
        button.addEventListener('click', function() {
        
            var productId = button.getAttribute('data-product-id');
        
            window.location.href = '?view=admin-products&product_id=' + productId;
        });
    });
</script>

