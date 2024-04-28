<?php

require_once "utilities/redirectToView.php";

?>

<h3 class="mt-4">Cart</h3>
<form method="post" action="?view=admin-home">
    <?php foreach ($_SESSION['cart'] as $product) : ?>
        <div class="card my-3 w-100">
            <div class="card-body d-flex">
                <div class="d-flex flex-row justify-content-between align-items-center w-50 me-3">
                    <h5><?php echo $product['name']; ?></h5>
                    <p><?php echo $product['price'] * $product['quantity']; ?> EGP</p>
                </div>
                <div class="d-flex justify-content-end align-items-center gap-1 w-50 me-4">
                    <p class="me-3">Quantity: <?php echo $product['quantity']; ?></p>
                    <button name="change_count" value="<?php echo $product['id'] . " " . ($product['quantity'] + 1); ?>" class="btn btn-secondary btn-increase">+</button>
                    <button name="change_count" value="<?php echo $product['id'] . " " . ($product['quantity'] - 1); ?>" class="btn btn-secondary btn-decrease">-</button>
                </div>
                <button name="remove_product" value="<?php echo $product['id']; ?>" class="btn btn-danger">Remove</button>
            </div>
        </div>
    <?php endforeach; ?>
</form>

<label class="fs-5 mt-3" for="notes">Notes</label>
<textarea id="notes" name="notes" rows="4" cols="50" style="resize: none;"></textarea>

<span class="d-flex gap-3 mt-4">
    <label class="fs-5" for="room">Room</label>
    <select class="form-control w-50" id="room">
        <option value="">Choose...</option>
        <option value="option1">Cafteria</option>
        <option value="option2">Hall</option>
        <option value="option3">Office</option>
    </select>
</span>

<hr class="my-4">

<h2>
    <?php
    $totalPrice = 0;
    foreach ($_SESSION['cart'] as $product) {
        $totalPrice += $product['price'] * $product['quantity'];
    }

    echo $totalPrice . " EGP";
    ?>
</h2>

<a href="#" class="btn btn-primary my-4">Confirm</a>

<?php
if (isset($_POST['remove_product'])) {
    $productId = $_POST['remove_product'];

    // $db = Database::getInstance();
    // $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // $db->delete('products', $productId);

    $db_products = array_values(array_filter($_SESSION['cart'], fn ($obj) => $obj['id'] != $productId));
    $_SESSION['cart'] = $db_products;

    echo "<script>window.location.reload()</script>";
}

if (isset($_POST['change_count'])) {
    $data = $_POST['change_count'];
    $data = explode(" ", $data);

    $productId = $data[0];
    $productQuantity = $data[1];

    // $db = Database::getInstance();
    // $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // $db->update('products', $productId, "quantity=$productQuantity");

    $index = array_search($productId, array_column($_SESSION['cart'], 'id'));

    if ($index !== false) {
        $_SESSION['cart'][$index]['quantity'] = $productQuantity;
    }

    echo "<script>window.location.reload()</script>";
}
