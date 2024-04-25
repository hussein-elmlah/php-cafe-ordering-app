<?php
    function redirectToView($view) {
        $baseHref = rtrim(dirname($_SERVER['PHP_SELF']), '/');
        // echo "<script>alert('baseHref: |$baseHref|');</script>";
        $url = "http://$_SERVER[HTTP_HOST]$baseHref/?view=$view";
        echo "<script>window.location.href = '$url';</script>";
    }
?>
