<?php
include("db.php");

// knihy ktoré sú voľné
$books = mysqli_query($conn, "SELECT * FROM books WHERE available = 1");

// users
$users = mysqli_query($conn, "SELECT * FROM users");

// po odoslaní formulára
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $book_id = $_POST["book_id"];
    $user_id = $_POST["user_id"];

    // uloz do loans
    mysqli_query($conn, "INSERT INTO loans (book_id, user_id) VALUES ($book_id, $user_id)");

    // nastav knihu ako požičanú
    mysqli_query($conn, "UPDATE books SET available = 0 WHERE id = $book_id");

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Požičať knihu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Požičanie knihy</h1>

<form method="POST">

    <select name="book_id">
        <?php while($b = mysqli_fetch_assoc($books)): ?>
            <option value="<?= $b['id'] ?>">
                <?= $b['title'] ?>
            </option>
        <?php endwhile; ?>
    </select>

    <select name="user_id">
        <?php while($u = mysqli_fetch_assoc($users)): ?>
            <option value="<?= $u['id'] ?>">
                <?= $u['name'] ?>
            </option>
        <?php endwhile; ?>
    </select>

    <button type="submit">Požičať</button>

</form>

</body>
</html>