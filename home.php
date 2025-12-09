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
    </style>
</head>

<body>

    <div class="navbar">
        <a href="home.php">Acasa</a>
        <?php if($isAdmin): ?>
            <a href="vizualizare.php">Vizualizare Produse</a>
        <?php endif; ?>
        <a href="index.php">Adaugare Produse In Cos</a>
        <a href="cart.php">Cos Cumparaturi</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="content">
        <h2>Bine ati venit!</h2>
                <?php if($isAdmin): ?>
            <h2>Esti conectat ca administrator!!</h2>
        <?php endif; ?>
        <!-- <img src="https://e-store.ro/wp-content/uploads/2024/02/e-Store-Logo-Mascote-Final-dreptunghiular.png"> -->
    </div>

</body>

</html>