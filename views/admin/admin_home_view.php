<?php include_once 'controllers/admin_home_controller.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-5">
            <?php include_once 'includes/cart.php'; ?>
        </div>
        <div class="col-7 p-4">
            <div class="container-fluid">
                <div class="row">
                    <?php include_once 'includes/choose_user.php'; ?>
                </div>
                <div class="row">
                    <?php include_once 'includes/products_list.php'; ?>
                </div>
            </div>
        </div>
    </div>
</div>
