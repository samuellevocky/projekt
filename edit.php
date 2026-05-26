<?php
include("db.php");

$id = $_GET["id"];

// načítaj knihu
$result = mysqli_query($conn, "SELECT * FROM books WHERE id=$id");
$book = mysqli_fetch_assoc($result);

$error = ""; // Premenná na uloženie prípadnej chyby

// update po odoslaní formulára
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $author = $_POST["author"];
    $year = (int)$_POST["year"]; // Pretypujeme na celé číslo
    $current_year = (int)date("Y"); // Zistíme aktuálny rok

    // Zmena podmienky: rok nesmie byť menší alebo rovný 0 a nesmie byť väčší ako aktuálny rok
    if ($year <= 0 || $year > $current_year) {
        $error = "Rok musí byť väčší ako 0 a maximálne rovný aktuálnemu roku ($current_year)!";
    } else {
        $sql = "UPDATE books 
                SET title='$title', author='$author', year='$year'
                WHERE id=$id";

        mysqli_query($conn, $sql);

        header("Location: index.php");
        exit();
    }
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
    <?php if (!empty($error)): ?>
        <p style="color: #ef4444; margin-bottom: 15px; font-weight: bold;"><?= $error ?></p>
    <?php endif; ?>

    <input type="text" name="title" value="<?= $book['title'] ?>" required>
    <input type="text" name="author" value="<?= $book['author'] ?>" required>
    
    <input type="number" name="year" value="<?= $book['year'] ?>" min="1" max="<?= date('Y') ?>" required>

    <button type="submit">Ulozit zmeny</button>
</form>

<br>
<a href="index.php">Spat</a>

</body>
</html>