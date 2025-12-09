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

if(!$isAdmin) {
    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <title>Vizualizare Inregistrari</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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
        <a href="vizualizare.php">Vizualizare Produse</a>
        <a href="index.php">Adaugare Produse In Cos</a>
        <a href="cart.php">Cos Cumparaturi</a>
        <a href="logout.php">Logout</a>
    </div>


    <h1>Inregistrarile din tabela tbl_product</h1>
    <p><b>Toate inregistrarile din tbl_product</b></p>

    <?php
    // conectare bază de date
    // include("Conectare.php");

    try {
        // se preiau inregistrarile din baza de date
        $stmt = $pdo->query("SELECT * FROM tbl_product ORDER BY id");

        if ($stmt->rowCount() > 0) {

            echo "<table border='1' cellpadding='10'>";
            if($isAdmin) {
            echo "<tr>
                    <th>ID</th>
                    <th>Nume Produs</th>
                    <th>Cod Produs</th>
                    <th>Imagine</th>
                    <th>Pret</th>
                    <th></th>
                    <th></th>
                  </tr>";
            } else {
                echo "<tr>
                    <th>ID</th>
                    <th>Nume Produs</th>
                    <th>Cod Produs</th>
                    <th>Imagine</th>
                    <th>Pret</th>
                  </tr>";
            }

            while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row->id) . "</td>";
                echo "<td>" . htmlspecialchars($row->name) . "</td>";
                echo "<td>" . htmlspecialchars($row->code) . "</td>";
                echo "<td><img src='" . htmlspecialchars($row->image) . "' alt='Imagine' width='100'></td>";
                echo "<td>" . htmlspecialchars($row->price) . "</td>";
                if($isAdmin) {
                    echo "<td><a href='Modificare.php?id=" . htmlspecialchars($row->id) . "'>Modificare</a></td>";
                    echo "<td><a href='Stergere.php?id=" . htmlspecialchars($row->id) . "'>Stergere</a></td>";
                }
                else {
                    echo "";
                }
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Nu sunt inregistrari in tabela!";
        }
    } catch (PDOException $e) {
        echo "Eroare la interogare: " . htmlspecialchars($e->getMessage());
    }
    echo '<br><br>';
    if($isAdmin) {
    echo '<a href="Inserare.php">Adaugarea unei noi inregistrari</a>';
    }
    ?>


</body>

</html>
