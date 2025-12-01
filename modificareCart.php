<?php
session_start();
require_once 'DBController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$db = new DBController();
$member_id = $_SESSION['user_id'];

$cart_items = $db->getDBResult(
    "SELECT p.name, p.price, c.quantity, c.id, c.product_id 
     FROM tbl_cart c 
     JOIN tbl_product p ON c.product_id = p.id 
     WHERE c.member_id = ?",
    [$member_id]
);

echo "<h1>Cos de cumparaturi</h1>";

foreach ($cart_items as $item) {
    echo "<div>" . htmlspecialchars($item['name']) .
        " - $" . htmlspecialchars($item['price']) . "
         <form method='post' action='updateCart.php'>
             <input type='number' name='quantity' value='" . (int)$item['quantity'] . "' min='1' />
             <input type='hidden' name='cart_id' value='" . (int)$item['id'] . "' />
             <input type='submit' value='Actualizeaza' />
         </form>
         <a href='removeFromCart.php?cart_id=" . (int)$item['id'] . "'>Scoate</a>
         </div>";
}

echo "<a href='emptyCart.php'>Goleste cosul</a>";
