<?php
session_start();
require_once 'DBController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


$db = new DBController();
$member_id = (int)$_SESSION['user_id'];

$cart_items = $db->getDBResult(
    "SELECT p.name, p.price, c.quantity, c.id
     FROM tbl_cart c
     JOIN tbl_product p ON c.product_id = p.id
     WHERE c.member_id = ?",
    [$member_id]
);

$total = 0;
if(!empty($cart_items)) {
    foreach($cart_items as $item) {
        $total += $item['price'] * $item['quantity'];
    }
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

<?php
require __DIR__.'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Cos de cumparaturi</title>
    <script src="https://js.stripe.com/v3/"></script>
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
            background-color: #6772e5;
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }

        #button-gol {
            background-color: #b5851ea0;
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
        <h2>Vizualizeaza cosul de cumparaturi!</h2>

        <h1>Cos de cumparaturi</h1>

        <?php if (empty($cart_items)) : ?>
            <p>Cosul tau este gol.</p>
        <?php else : ?>
            <?php foreach ($cart_items as $item) : ?>
                <div>
                    <?php
                    echo htmlspecialchars($item['name'])
                        . " - $" . htmlspecialchars($item['price'])
                        . " x " . (int)$item['quantity'];
                    ?>
                    <a href="removeFromCart.php?cart_id=<?php echo (int)$item['id']; ?>">Scoate</a>
                </div>
            <?php endforeach; ?>

            <hr>
            <div>
                <strong>Total: $<?php echo number_format($total, 2); ?></strong>
            </div>

            <button id="button">Plateste</button>
        <?php endif; ?>

        <br>
        <br><br>
        <a id="button-gol" href="emptyCart.php">Goleste cosul</a>
    </div>

    <script>
        const stripe = Stripe("<?=  $_ENV['STRIPE_PUBLIC']; ?>");
        
        const paymentButtom = document.getElementById('button');

        paymentButtom.addEventListener('click', () => {
            fetch('create-checkout-session.php', {
                method: 'POST',
            })
            .then(response => response.json())
            .then(session => {
                if(session.id) {
                    return stripe.redirectToCheckout({
                        sessionId: session.id
                    });
                } else {
                    console.error('eroare la checkokut!');
                }
            })
            .catch(error => {
                console.error('Error', error);
            });
        })
    </script>

</body>

</html>