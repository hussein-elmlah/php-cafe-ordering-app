<?php
function redirectToPage($page) {
    $baseHref = "http://localhost/osad44/php/PHP-Cafe-App/php-cafe-ordering-app";
    $url = $baseHref . "?page=" . $page;
    echo "<script>window.location.href = '$url';</script>";
}
?>
