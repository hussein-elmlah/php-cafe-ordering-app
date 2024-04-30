<?php include_once 'controllers/user_home_controller.php'; ?>

<head>
    <style>
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<div class="container-fluid p-0">
    <div class="row">
        <div class="col-5">
            <h3 class="mt-4">Cart</h3>
            <form method="post" action="?view=home">
                <?php foreach ($_SESSION['cart'] as $product) : ?>
                    <div class="card my-3 w-100">
                        <div class="card-body d-flex">
                            <div class="d-flex flex-row justify-content-between align-items-center w-50 me-3">
                                <h5><?php echo $product['name']; ?></h5>
                                <p><?php echo $product['price'] * $product['quantity']; ?> EGP</p>
                            </div>
                            <div class="d-flex justify-content-end align-items-center gap-1 w-50 me-4">
                                <p class="me-3">Q: <?php echo $product['quantity']; ?></p>
                                <button name="change_count" value="<?php echo $product['id'] . " " . ($product['quantity'] + 1); ?>" class="btn btn-secondary btn-increase">+</button>
                                <button name="change_count" value="<?php echo $product['id'] . " " . ($product['quantity'] - 1); ?>" class="btn btn-secondary btn-decrease">-</button>
                            </div>
                            <button name="remove_product" value="<?php echo $product['id']; ?>" class="btn btn-danger">Remove</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </form>
            <form method="post" action="?view=home">
                <div class="d-flex flex-column">
                    <label class="fs-5 mt-3" for="notes">Notes</label>
                    <textarea id="notes" name="notes" rows="4" cols="50" style="resize: none;"></textarea>
                </div>
                <span class="d-flex gap-3 mt-4">
                    <label class="fs-5" for="room">Room</label>
                    <select class="form-control w-50" name="room">
                        <option value="">Choose...</option>
                        <option value="Cafeteria">Cafeteria</option>
                        <option value="Hall">Hall</option>
                        <option value="Office">Office</option>
                    </select>
                </span>
                <hr class="my-4">
                <h2>
                    <?php
                    $totalPrice = 0;
                    $total_amount = 0; 
                    foreach ($_SESSION['cart'] as $product) {
                        $totalPrice += $product['price'] * $product['quantity'];
                        $total_amount +=  $product['quantity'];
                    }

                    echo $totalPrice . " EGP";
                    ?>
                </h2>
                <button name="order_cart" class="btn btn-primary my-4">Confirm</button>
            </form>
        </div>
        <div class="col-7 p-4">
            <div class="container-fluid">
                <div class="row">
                    <form method="post" class="d-flex flex-wrap gap-3">
                        <?php foreach ($products as $product) : ?>
                            <div class="card" style="width: 18rem; cursor: pointer;">
                                <img src="public/images/drink.jpg" class="card-img-top" alt="Drink">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?php echo $product['name']; ?></h5>
                                    <p class="card-text"><?php echo $product['price'] . ' EGP'; ?></p>
                                    <a href="home&product=<?php echo $product['id']; ?>" class="btn btn-primary mt-2">Add to cart</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>