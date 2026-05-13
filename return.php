<?php
include("db.php");

// vratenie knihy
if (isset($_GET["loan_id"])) {

    $loan_id = $_GET["loan_id"];

    // zisti book_id
    $res = mysqli_query($conn, "SELECT book_id FROM loans WHERE id=$loan_id");
    $row = mysqli_fetch_assoc($res);
    $book_id = $row["book_id"];

    // nastav return date
    mysqli_query($conn, "UPDATE loans SET return_date = NOW() WHERE id=$loan_id");

    // kniha je znovu dostupná
    mysqli_query($conn, "UPDATE books SET available = 1 WHERE id=$book_id");

    header("Location: index.php");
}
?>