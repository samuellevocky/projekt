<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect("127.0.0.1", "root", "root", "library_db");

if (!$conn) {
    die("DB CHYBA: " . mysqli_connect_error());
}

echo "DB OK";
?>