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
<a href="create.php" class="btn">+ Pridat knihu</a>
<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Nazov</th>
    <th>Autor</th>
    <th>Rok</th>
    <th>Status</th>
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

</tr>

<?php endwhile; ?>

</table>

</body>
</html>