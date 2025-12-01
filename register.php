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
        <a href="register.php">Register</a>
    </div>

    <div class="content">
        <h2>Bine ai venit!</h2>
        <h2>Intregistreaza-te!!</h2>
    </div>

</body>

</html>

<?php
require_once 'DBController.php';
// există un controller pentru baza de date
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Criptăm parola
    $db = new DBController();
    $query = "INSERT INTO users (username, password) VALUES (?, ?)";
    try {
        $db->updateDB($query, [$username, $password]);
        echo "Înregistrare reușită!";
    } catch (Exception $e) {
        echo "Eroare: " . $e->getMessage();
    }
}
?>
<form method="post">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Register</button>
</form>