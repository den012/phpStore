<?php
session_start();
require_once 'DBController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Aici poti verifica sesiunea Stripe pentru extra securitate, daca doresti.

$db = new DBController();
$member_id = (int)$_SESSION['user_id'];
$db->getDBResult("DELETE FROM tbl_cart WHERE member_id = ?", [$member_id]);


?>
<!DOCTYPE html>
<html>
<head>
    <title>Plata Reusita</title>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        h1 {
            font-size: 2rem;
            color:green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Multumim pentru comanda!</h1>
        <p>Plata a fost procesata cu succes.</p>
        <p>Vei primi in curand un email de confirmare.</p>
        <a href="home.php">Inapoi la pagina principala</a>
    </div>

    <script>
        setTimeout(() => {
            window.location.href='home.php';
        }, 4000);
    </script>
</body>
</html>