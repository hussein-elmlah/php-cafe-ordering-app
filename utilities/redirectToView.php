<?php
function redirectToView($view) {
    $baseHref = "http://localhost/osad44/php/PHP-Cafe-App/php-cafe-ordering-app";
    $url = $baseHref . "?view=" . $view;
    echo "<script>window.location.href = '$url';</script>";
}
?>
