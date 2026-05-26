<?php
include("db.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET["loan_id"])) {
    $loan_id = intval($_GET["loan_id"]);
    $user_id = $_SESSION["user_id"];
    $role = $_SESSION["role"];

    // Admin môže vrátiť čokoľvek, bežný používateľ iba svoju vlastnú knihu
    if ($role === "admin") {
        $check_sql = "SELECT book_id FROM loans WHERE id = $loan_id AND return_date IS NULL";
    } else {
        $check_sql = "SELECT book_id FROM loans WHERE id = $loan_id AND user_id = $user_id AND return_date IS NULL";
    }

    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $loan = mysqli_fetch_assoc($check_result);
        $book_id = $loan["book_id"];
        $return_date = date("Y-m-d");

        $update_loan = "UPDATE loans SET return_date = '$return_date' WHERE id = $loan_id";
        $update_book = "UPDATE books SET available = 1 WHERE id = $book_id";

        if (mysqli_query($conn, $update_loan) && mysqli_query($conn, $update_book)) {
            header("Location: index.php");
            exit();
        } else {
            echo "Chyba pri spracovaní vrátenia: " . mysqli_error($conn);
        }
    } else {
        echo "Nemáš právo vrátiť túto knihu, alebo už bola vrátená.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>