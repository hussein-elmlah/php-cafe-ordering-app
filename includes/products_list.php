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
