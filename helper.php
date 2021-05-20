<?php


function dd($data) {
    var_dump($data);
    die();
}

function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function alert($msg) {
	echo "<script>
            alert('$msg');
            window.location.href='$url';
        </script>";
}

function aredirect($msg, $url) {
    $url = explode('/', $url);
    $url = end($url);
	echo "<script>
            alert('$msg');
            window.location.href='$url';
        </script>";
}

function redirect($url) {
    ob_start();
    header("Location: ". $url);
    ob_end_flush();
    die();
}
