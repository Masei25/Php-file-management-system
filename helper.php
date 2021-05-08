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
	echo "<script>alert('$msg');</script>";
}
