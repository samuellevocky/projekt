<?php
include("db.php");

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $name = mysqli_real_escape_string($conn, $_POST["name"]);

    // Kontrola, či už také používateľské meno neexistuje
    $checkUser = mysqli_query($conn, "SELECT id FROM users WHERE username = '$username'");
    
    if (mysqli_num_rows($checkUser) > 0) {
        $error = "Používateľské meno už existuje! Zvoľ si iné.";
    } else {
        // Rola 'user' je tu natvrdo, nikto si nemôže vytvoriť admina
        $sql = "INSERT INTO users (username, password, name, role) VALUES ('$username', '$password', '$name', 'user')";
        
        if (mysqli_query($conn, $sql)) {
            $success = "Registrácia prebehla úspešne! Presmerovávam...";
            header("Refresh: 2; url=login.php"); 
        } else {
            $error = "Chyba pri registrácii: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Registrácia žiaka</title>
</head>
<body>

<div class="form-container">
    
    <a href="login.php" class="back-link">← Späť na prihlásenie</a>
    
    <h1>Registrácia žiaka</h1>

    <?php if (!empty($error)): ?>
        <p class="error-msg"><?= $error ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success-msg"><?= $success ?></p>
    <?php endif; ?>

    <?php if (empty($success)): ?>
        <form method="POST">
            
            <div class="form-group">
                <label for="name">Celé meno:</label>
                <input type="text" name="name" id="name" required class="form-control" placeholder="napr.: Adam Novak">
            </div>

            <div class="form-group">
                <label for="username">Používateľské meno (Login):</label>
                <input type="text" name="username" id="username" required class="form-control" placeholder="napr.: adam12">
            </div>

            <div class="form-group">
                <label for="password">Heslo:</label>
                <input type="password" name="password" id="password" required class="form-control" placeholder="••••••••">
            </div>

            <button type="submit" class="btn">Zaregistrovať sa</button>
        </form>
    <?php endif; ?>

</div>

</body>
</html>