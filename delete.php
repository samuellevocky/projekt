<?php
include("db.php");
// Ak užívateľ nie je admin, zastavíme skript a vypíšeme chybu
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    die("CHYBA: Nemáš administratívne práva na túto akciu!");
}
$id = $_GET["id"];

$sql = "DELETE FROM books WHERE id=$id";
mysqli_query($conn, $sql);

header("Location: index.php");
?>