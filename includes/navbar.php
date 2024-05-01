<?php

$isLoggedIn = @$_SESSION['is_auth'];
$isAdmin = @$_SESSION['is_admin'];
$userName = @$_SESSION['user_name'];

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid px-4 fs-5">
        <a class="navbar-brand" href="?view=home">
            <i class="fas fa-coffee"></i>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if (!$isAdmin || !$isLoggedIn) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?view=#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?view=user-orders">Orders</a>
                    </li>
                <?php endif; ?>
                <?php if ($isAdmin && $isLoggedIn) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?view=admin-categories">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?view=admin-products">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?view=admin-orders">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?view=admin-users">Users</a>

                    </li>
                <?php endif; ?>
            </ul>
            <div class="d-flex">
                <?php if (!$isLoggedIn) : ?>
                    <a href="?view=login" class="btn btn-outline-light me-2">Login</a>
                    <a href="?view=register&action=register" class="btn btn-outline-light">Register</a>
                <?php endif; ?>
                <?php if ($isLoggedIn) : ?>
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $userName ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="?view=logout" onclick="handleLogout()">Logout</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>


<script>
    // function redirectToLink(event) {
    //     event.preventDefault();
    //     var baseHref = window.location.pathname; // "http://localhost/cafe"
    //     var view = event.target.getAttribute('href');
    //     window.location.href = baseHref + "?" + "view=" + view;
    // }

    // function addClickEventToNavbarLinks() {
    //     var navbarLinks = document.querySelectorAll('a.nav-link, a');
    //     navbarLinks.forEach(function(link) {
    //         link.onclick = redirectToLink;
    //     });
    // }

    // document.addEventListener('DOMContentLoaded', addClickEventToNavbarLinks);

    // function handleLogout() {
    //     window.location.href = "logout";
    // }
</script>