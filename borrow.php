<?php
include("db.php");

date_default_timezone_set('Europe/Bratislava');

// KONTROLA: Ak nie je prihlásený, pošli ho na login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = intval($_POST["book_id"]);
    $user_id = $_SESSION["user_id"]; 

    // Kontrola, či je kniha stále voľná
    $checkBook = mysqli_query($conn, "SELECT available FROM books WHERE id = $book_id");
    $bookData = mysqli_fetch_assoc($checkBook);

    if ($bookData && $bookData['available'] == 1) {
        // Zmena tu: Pridali sme H:i:s, aby to ukladalo aj presný čas pôžičky
        $loan_date = date("Y-m-d H:i:s");

        // 1. Zápis do tabuľky loans
        $sql_loan = "INSERT INTO loans (book_id, user_id, loan_date) VALUES ($book_id, $user_id, '$loan_date')";
        
        // 2. Aktualizácia statusu knihy na požičanú
        $sql_update_book = "UPDATE books SET available = 0 WHERE id = $book_id";

        if (mysqli_query($conn, $sql_loan) && mysqli_query($conn, $sql_update_book)) {
            $success = "Kniha bola úspešne požičaná!";
            header("Refresh: 2; url=index.php"); 
        } else {
            $error = "Chyba pri spracovaní pôžičky: " . mysqli_error($conn);
        }
    } else {
        $error = "Táto kniha momentálne nie je dostupná.";
    }
}

// Načítame iba tie knihy, ktoré sú voľné
$books_result = mysqli_query($conn, "SELECT * FROM books WHERE available = 1");
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Požičať knihu</title>
</head>
<body>

<div class="form-container">
    
    <a href="index.php" class="back-link">← Späť na prehľad</a>
    
    <h1>Požičať knihu</h1>

    <?php if (!empty($error)): ?>
        <p class="error-msg"><?= $error ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success-msg"><?= $success ?></p>
    <?php endif; ?>

    <?php if (empty($success)): ?>
        <?php if (mysqli_num_rows($books_result) > 0): ?>
            <form method="POST">
                
                <div class="form-group">
                    <label>Kniha sa zapíše na účet:</label>
                    <input type="text" value="<?= $_SESSION["user_name"] ?>" disabled class="form-control disabled-input">
                </div>

                <div class="form-group">
                    <label for="book_id">Vyber si voľnú knihu:</label>
                    <select name="book_id" id="book_id" required class="form-control">
                        <option value="">-- Vyber knihu --</option>
                        <?php while($book = mysqli_fetch_assoc($books_result)): ?>
                            <option value="<?= $book['id'] ?>"><?= $book['title'] ?> (<?= $book['author'] ?>)</option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <button type="submit" class="btn">Potvrdiť pôžičku</button>
            </form>
        <?php else: ?>
            <p style="color: #64748b; font-style: italic; text-align: center; margin-top: 20px;">Momentálne sú všetky knihy v knižnici požičané.</p>
        <?php endif; ?>
    <?php endif; ?>

</div>

</body>
</html>