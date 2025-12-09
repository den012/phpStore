<?php
session_start();
require_once 'DBController.php';
include("Conectare.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_email = '';
try {
    $stmt_user = $pdo->prepare("SELECT email FROM users WHERE id = ?");
    $stmt_user->execute([$_SESSION['user_id']]);
    $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $user_email = $user['email'];
    }
} catch (PDOException $e) {
}

$db = new DBController();
$member_id = (int)$_SESSION['user_id'];
$db->getDBResult("DELETE FROM tbl_cart WHERE member_id = ?", [$member_id]);


$to = $user_email;
$subject = "Confirmare comanda - Plata a fost procesata cu succes";

$from = "denisdenis668@yahoo.com";

// Headers
$headers  = "From: $from\r\n";
$headers .= "Reply-To: $from\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

$body = "
<html>
<body>
    <h1>Multumim pentru comanda!</h1>
    <p>Plata dumneavoastra a fost procesata cu succes.</p>
    <p>Acesta este un email de confirmare. Veti primi detaliile comenzii in curand.</p>
</body>
</html>";


$sent = mail($to, $subject, $body, $headers);

if($sent) {
    echo "<h1>mail trimis cu succes la $user_email</h1><br<br>";
} else {
    echo "eroare la trimitere";
}

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