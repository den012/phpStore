<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include("Conectare.php");
$isAdmin = false; // Default to not admin
try {
    $stmt_user = $pdo->prepare("SELECT is_admin FROM users WHERE id = ?");
    $stmt_user->execute([$_SESSION['user_id']]);
    $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['is_admin'] == 1) {
        $isAdmin = true;
    }
} catch (PDOException $e) {
    die("Eroare la verificarea utilizatorului: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Acasa</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: #1e1e1e;
            padding: 15px;
            display: flex;
            gap: 20px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 8px 12px;
        }

        .navbar a:hover {
            background: #333333;
            border-radius: 4px;
        }

        .content {
            padding: 20px;
        }

        li {
            display: flex;
            flex-direction: row;
        }
        #img {
            width: 150px;
            height: 170px;
            margin-right: 15px;
        }
        #text {
            font-size: 1.5rem;
        }
        #button {
            background-color: #da3974c0;
            width: 100px;
            height: 30px;
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <a href="home.php">Acasa</a>
        <?php if ($isAdmin): ?>
            <a href="vizualizare.php">Vizualizare Produse</a>
        <?php endif; ?>
        <a href="index.php">Adaugare Produse In Cos</a>
        <a href="cart.php">Cos Cumparaturi</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="content">
        <h2>Alege produsele dorite!</h2>
    </div>

</body>

</html>

<?php

require_once 'DBController.php';
$db = new DBController();
// preluăm produsele din baza de date
$products = $db->getDBResult("SELECT * FROM tbl_product");
echo "<h1>Produse disponibile</h1>";
echo "<ul>";
foreach ($products as $product) {
    $imagePath = htmlspecialchars($product['image']);
    echo "<li>"
        . "<img id='img' src='" . $imagePath . "' alt='" . htmlspecialchars($product['name']) . "' class='product-image'>"
        . "<span id='text'>" . htmlspecialchars($product['name']) . " - $" . htmlspecialchars($product['price']) . "</span>"
        . " <a href='addToCart.php?product_id=" . $product['id'] . "' id='button'>Adaugă în coș</a></li>";
}
echo "</ul>";
