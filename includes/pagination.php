<?php

function Pagination($currentPage, $totalPages) {
    // echo "<script>alert('currentPage: |$currentPage| , totalPages: |$totalPages| ');</script>";

    if ($totalPages < 1) {
        return;
    }

    echo '<div class="join pb-5 text-center">';

    // JavaScript function definition for onPageChange
    echo '<script>';
    echo 'function onPageChange(page) {';
    echo '    var url = "' . $_SERVER['REQUEST_URI'] . '";';
    echo '    var separator = url.indexOf("?") !== -1 ? "&" : "?";';
    echo '    var newUrl;';
    echo '    if (url.indexOf("page=") !== -1) {';
    echo '        newUrl = url.replace(/(page=)[^&]+/, "$1" + page);';
    echo '    } else if (url.indexOf("?") !== -1) {';
    echo '        newUrl = url + "&page=" + page;';
    echo '    } else {';
    echo '        newUrl = url + "?page=" + page;';
    echo '    }';
    echo '    window.location.href = newUrl;';
    echo '}';

    echo '</script>';

    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<button class="join-item btn border mx-1 bg-dark text-white" onclick="onPageChange(' . $i . ')">' . $i . '</button>';
    }
    echo '</div>';
    // var_dump($currentPage);
}

?>
