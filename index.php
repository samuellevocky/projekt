<?php
include("db.php");

$sql = "SELECT * FROM books";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Skolska kniznica</title>
</head>
<body>
<button id="themeToggle">Dark mode</button>
<h1>Skolska kniznica</h1>
<div class="dashboard">

    <div class="card">
        <h3>Počet kníh</h3>
        <p>
            <?php
            $countBooks = mysqli_query($conn, "SELECT COUNT(*) as total FROM books");
            echo mysqli_fetch_assoc($countBooks)['total'];
            ?>
        </p>
    </div>

    <div class="card">
        <h3>Požičané knihy</h3>
        <p>
            <?php
            $countLoans = mysqli_query($conn, "SELECT COUNT(*) as total FROM loans WHERE return_date IS NULL");
            echo mysqli_fetch_assoc($countLoans)['total'];
            ?>
        </p>
    </div>

    <div class="card">
        <h3>Používatelia</h3>
        <p>
            <?php
            $countUsers = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
            echo mysqli_fetch_assoc($countUsers)['total'];
            ?>
        </p>
    </div>

</div>
<a href="borrow.php" class="btn">Požičať knihu</a>
<a href="create.php" class="btn">+ Pridat knihu</a>
<table class="books-table">

<tr>
    <th>ID</th>
    <th>Nazov</th>
    <th>Autor</th>
    <th>Rok</th>
    <th>Status</th>
    <th>Akcie</th>
</tr>



<?php while($row = $result->fetch_assoc()): ?>

<tr>

<td><?= $row['id'] ?></td>

<td><?= $row['title'] ?></td>

<td><?= $row['author'] ?></td>

<td><?= $row['year'] ?></td>

<td>
<?= $row['available'] ? "Volna" : "Pozicana" ?>
</td>

<td>
    <a href="edit.php?id=<?= $row['id'] ?>">Upravit</a>
    <a href="delete.php?id=<?= $row['id'] ?>">Vymazat</a>
</td>

</tr>

<?php endwhile; ?>

</table>

<h2>Požičané knihy</h2>

<?php
$sql = "SELECT loans.id, books.title, users.name, loans.loan_date
        FROM loans
        JOIN books ON loans.book_id = books.id
        JOIN users ON loans.user_id = users.id
        WHERE loans.return_date IS NULL";

$result = mysqli_query($conn, $sql);
?>

<table class="books-table">
<tr>
    <th>Kniha</th>
    <th>Používateľ</th>
    <th>Dátum</th>
    <th>Akcia</th>
</tr>

<?php while($l = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= $l["title"] ?></td>
    <td><?= $l["name"] ?></td>
    <td><?= $l["loan_date"] ?></td>
    <td>
        <a href="return.php?loan_id=<?= $l['id'] ?>">Vrátiť</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
<script>
const btn = document.getElementById("themeToggle");

btn.addEventListener("click", () => {
    document.body.classList.toggle("dark");
});
</script>
</body>
</html>