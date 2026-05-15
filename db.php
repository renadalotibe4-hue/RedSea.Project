<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "redsea";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("فشل الاتصال: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");
?>