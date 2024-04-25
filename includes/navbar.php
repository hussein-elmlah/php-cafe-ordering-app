<?php 

    // Temporary placeholder values for user role, first name and isLoggedIn
    $loggedUser = array(
        'isAdmin' => true,
        'first_name' => 'Hussein'
    );
    $isLoggedIn = true;
    
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid px-4 fs-5">
        <a class="navbar-brand" href="#">
            <i class="fas fa-coffee"></i>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if (!$loggedUser['isAdmin'] || !$isLoggedIn): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/shop">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/wishlist">Wishlist</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/shoppingCart">Cart</a>
                    </li>
                <?php endif; ?>
                <?php if ($loggedUser['isAdmin']): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/categories">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/products">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/orders">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/cafe/views/admin/admin_users_view.php">Users</a>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="d-flex">
                <?php if (!$loggedUser['isAdmin'] || !$isLoggedIn): ?>
                    <a href="/shop" class="btn btn-outline-light me-2">Shop</a>
                <?php endif; ?>
                <?php if (!$isLoggedIn): ?>
                    <a href="/login" class="btn btn-outline-light me-2">Login</a>
                    <a href="/register" class="btn btn-outline-light">Register</a>
                <?php endif; ?>
                <?php if ($isLoggedIn): ?>
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $loggedUser['first_name'] ?> <!-- Placeholder value -->
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="/userprofile">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/" onclick="handleLogout()">Logout</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
