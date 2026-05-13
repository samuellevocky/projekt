<?php
include("db.php");

$sql = "SELECT * FROM books";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Skolska kniznica</title>
</head>
<body>

<h1>Skolska kniznica</h1>
<a href="borrow.php" class="btn">Požičať knihu</a>
<a href="create.php" class="btn">+ Pridat knihu</a>
<table border="1" cellpadding="10">

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

<table border="1">
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

</body>
</html>