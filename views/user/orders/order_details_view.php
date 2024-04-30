<?php
$UserOrders = new UserOrdersController();
?>
<section class="h-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-10 col-xl-8">
                <div class="card" style="border-radius: 10px;">
                    <div class="card-header px-4 py-5">
                        <h5 class="text-muted mb-0">your Order, <span style="color: #834A1C;"><?php echo $_SESSION['user_name'] ?></span>!</h5>
                    </div>
                    <div class="card-body p-4">
                        <?php foreach ($items as $item) : ?>
                            <?php
                            $product_item = $UserOrders->getProduct($item['product_id']);
                            ?>
                            <div class="card shadow-0 border mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img src="<?php echo $product_item[0]['image']; ?>" class="img-fluid" alt="Phone">
                                        </div>
                                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                            <p class="text-muted mb-0"><?php echo $product_item[0]['name']; ?></p>
                                        </div>
                                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                            <p class="text-muted mb-0 small">Qty: <?php echo $item['quantity'] ?></p>
                                        </div>
                                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                            <p class="text-muted mb-0 small"><?php echo $product_item[0]['price'] ?> EGP</p>
                                        </div>
                                    </div>
                                    <hr class="mb-4" style="background-color: #e0e0e0; opacity: 1;">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="card-footer border-0 px-4 py-5" style="background-color: #834A1C; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                        <h5 class="d-flex align-items-center justify-content-end text-white text-uppercase mb-0">Total
                            paid: <span class="h2 mb-0 ms-2"><?php echo $_GET['total_price']?> EGP</span></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    body {
        background: url(https://images.unsplash.com/photo-1495195129352-aeb325a55b65?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1776&q=80);
        background-size: cover;
        background-position: right;
        background-attachment: fixed;
    }
</style>