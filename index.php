<?php
include("db.php");

// KONTROLA: Ak nie je prihlásený, pošli ho na login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

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

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <p>Prihlásený: <strong><?= $_SESSION["user_name"] ?></strong> (Rola: <?= $_SESSION["role"] ?>)</p>
    <div>
        <button id="themeToggle" style="margin-right: 10px;">Dark mode</button>
        <a href="logout.php" style="background: #ef4444; color: white; padding: 10px 15px; border-radius: 8px; text-decoration: none;">Odhlásiť sa</a>
    </div>
</div>

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

<?php if ($_SESSION["role"] === "admin"): ?>
    <a href="create.php" class="btn">+ Pridat knihu</a>
<?php endif; ?>

<table class="books-table" style="margin-top: 20px;">
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
    <?php if ($_SESSION["role"] === "admin"): ?>
        <a href="edit.php?id=<?= $row['id'] ?>">Upravit</a> | 
        <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Naozaj vymazať?')">Vymazat</a>
    <?php else: ?>
        <span style="color: #64748b; font-size: 0.9em;">Iba pre admina</span>
    <?php endif; ?>
</td>
</tr>
<?php endwhile; ?>
</table>

<h2>Požičané knihy</h2>

<?php
// Do SELECTu pridávame loans.user_id, aby sme vedeli, kto si knihu požičal
$sql = "SELECT loans.id, books.title, users.name, loans.loan_date, loans.user_id
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
        <?php if ($_SESSION["role"] === "admin" || $_SESSION["user_id"] == $l["user_id"]): ?>
            <a href="return.php?loan_id=<?= $l['id'] ?>">Vrátiť</a>
        <?php else: ?>
            <span style="color: #64748b; font-size: 0.9em;">Požičané</span>
        <?php endif; ?>
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