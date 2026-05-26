<?php
include("db.php");

// Ak už užívateľ je prihlásený, hodíme ho rovno na index
if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = $_POST["password"]; // V praxi sa heslocuje (password_hash), ale pre školský projekt stačí takto v čistom texte

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Uložíme si dáta o prihlásenom do session
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["name"];
        $_SESSION["role"] = $user["role"];

        header("Location: index.php");
        exit();
    } else {
        $error = "Nesprávne prihlasovacie meno alebo heslo!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Prihlásenie</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div style="max-width: 400px; margin: 50px auto;">
    <h1>Prihlásenie</h1>

    <form method="POST">
        <?php if (!empty($error)): ?>
            <p style="color: #ef4444; font-weight: bold; margin-bottom: 15px;"><?= $error ?></p>
        <?php endif; ?>

        <input type="text" name="username" placeholder="Prihlasovacie meno" required>
        <input type="password" name="password" placeholder="Heslo" required>

        <button type="submit">Prihlásiť sa</button>
    </form>
    <div class="login-footer">
    <a href="register.php">Ešte nemáš účet? Zaregistruj sa tu</a>
</div>
</div>

</body>
</html>