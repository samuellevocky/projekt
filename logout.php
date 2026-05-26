<?php
include("db.php");
session_destroy(); // Zmaže všetky dáta o prihlásení
header("Location: login.php");
exit();
?>