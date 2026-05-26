<?php
include("db.php");

$error = ""; // Premenná na uloženie prípadnej chyby

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $author = $_POST["author"];
    $year = (int)$_POST["year"]; // Pretypujeme na celé číslo
    $current_year = (int)date("Y"); // Zistíme aktuálny rok

    // Zmena podmienky: rok nesmie byť menší alebo rovný 0 a nesmie byť väčší ako aktuálny rok
    if ($year <= 0 || $year > $current_year) {
        $error = "Rok musí byť väčší ako 0 a maximálne rovný aktuálnemu roku ($current_year)!";
    } else {
        $sql = "INSERT INTO books (title, author, year, available)
                VALUES ('$title', '$author', '$year', 1)";

        mysqli_query($conn, $sql);

        header("Location: index.php");
        exit();
    }
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
    <?php if (!empty($error)): ?>
        <p style="color: #ef4444; margin-bottom: 15px; font-weight: bold;"><?= $error ?></p>
    <?php endif; ?>

    <input type="text" name="title" placeholder="Nazov knihy" required>
    <input type="text" name="author" placeholder="Autor" required>
    
    <input type="number" name="year" placeholder="Rok" min="1" max="<?= date('Y') ?>" required>

    <button type="submit">Pridat</button>
</form>

<br>
<a href="index.php">Spat</a>

</body>
</html>