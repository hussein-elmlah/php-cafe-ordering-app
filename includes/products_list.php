<hr class="my-4">

<form method="post" action="" class="d-flex flex-wrap gap-3">
    <?php foreach ($products as $product) : ?>
        <div class="card" style="width: 18rem; cursor: pointer;">
            <img src="public/images/drink.jpg" class="card-img-top" alt="Drink">
            <div class="card-body text-center">
                <h5 class="card-title"><?php echo $product['name']; ?></h5>
                <p class="card-text"><?php echo $product['price'] . ' EGP'; ?></p>
                <a href="admin-home&product=<?php echo $product['id']; ?>" class="btn btn-primary mt-2">Add to cart</a>
            </div>
        </div>
    <?php endforeach; ?>
</form>

<?php if (isset($_GET['product'])) {
    $db = Database::getInstance();
    $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $db_products = $db->select('products');
    $db_product = array_values(array_filter($db_products, fn($obj) => $obj['id'] == $_GET['product']));

    function objectExists($array, $object) {
        foreach ($array as $item) {
            if ($item['id'] == $object['id']) {
                return true;
            }
        }
        return false;
    }

    $drink = $db_product[0];
    $drink['quantity'] = 1;

    if (!objectExists($_SESSION['cart'], $drink)) {
        $_SESSION['cart'][] = $drink;
    }
}
?>