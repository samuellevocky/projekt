<?php
include("db.php");

$books = mysqli_query($conn, "SELECT * FROM books WHERE available = 1");
$users = mysqli_query($conn, "SELECT * FROM users");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $book_id = $_POST["book_id"];
    $user_id = $_POST["user_id"];

    mysqli_query($conn, "INSERT INTO loans (book_id, user_id, loan_date) VALUES ($book_id, $user_id, NOW())");
    mysqli_query($conn, "UPDATE books SET available = 0 WHERE id = $book_id");

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Požičať knihu</title>
</head>
<body>

<h1>Požičanie knihy</h1>

<form method="POST">

    <label>Kniha:</label><br>
    <select name="book_id" required>
        <?php while($b = mysqli_fetch_assoc($books)): ?>
            <option value="<?= $b['id'] ?>">
                <?= $b['title'] ?>
            </option>
        <?php endwhile; ?>
    </select>

    <br><br>

    <label>Používateľ:</label><br>
    <select name="user_id" required>
        <?php while($u = mysqli_fetch_assoc($users)): ?>
            <option value="<?= $u['id'] ?>">
                <?= $u['name'] ?>
            </option>
        <?php endwhile; ?>
    </select>

    <br><br>

    <button type="submit">Požičať</button>

</form>

</body>
</html>