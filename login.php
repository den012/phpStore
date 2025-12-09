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

         #button {
            background-color: #2c33aac0;
            width: 100px;
            height: 40px;
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }

        .container {
            margin: 20px;
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
        <h2>Conecteaza-te!!</h2>
    </div>

</body>

</html>

<?php
session_start();
require_once 'dbcontroller.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $db = new DBController();
    $query = "SELECT id, password FROM users WHERE username = ?";
    $user = $db->getDBResult($query, [$username]);
    if ($user && password_verify($password, $user[0]['password'])) {
        $_SESSION['user_id'] = $user[0]['id'];
        header("Location: home.php");
        exit;
    } else {
        echo "Invalid username or password";
    }
}
?>
<form method="post">
    <div class="container">
        <strong>Username:</strong> <input type="text" name="username" required><br><br>
        <strong>Password</strong> <input type="password" name="password" required><br><br>
        <button type="submit" id="button">Login</button>
    </div>
</form>