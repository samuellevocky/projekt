<?php
include("db.php");

$id = $_GET["id"];

// načítaj knihu
$result = mysqli_query($conn, "SELECT * FROM books WHERE id=$id");
$book = mysqli_fetch_assoc($result);

// update po odoslaní formulára
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $author = $_POST["author"];
    $year = $_POST["year"];

    $sql = "UPDATE books 
            SET title='$title', author='$author', year='$year'
            WHERE id=$id";

    mysqli_query($conn, $sql);

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit knihy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Edit knihy</h1>

<form method="POST">
    <input type="text" name="title" value="<?= $book['title'] ?>" required>
    <input type="text" name="author" value="<?= $book['author'] ?>" required>
    <input type="number" name="year" value="<?= $book['year'] ?>" required>

    <button type="submit">Ulozit zmeny</button>
</form>

<br>
<a href="index.php">Spat</a>

</body>
</html>