<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $author = $_POST["author"];
    $year = $_POST["year"];

    $sql = "INSERT INTO books (title, author, year, available)
            VALUES ('$title', '$author', '$year', 1)";

    mysqli_query($conn, $sql);

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pridat knihu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Pridat knihu</h1>

<form method="POST">
    <input type="text" name="title" placeholder="Nazov knihy" required>
    <input type="text" name="author" placeholder="Autor" required>
    <input type="number" name="year" placeholder="Rok" required>

    <button type="submit">Pridat</button>
</form>

<br>
<a href="index.php">Spat</a>

</body>
</html>