//add to cart file

<?php
session_start();
require_once 'DBController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$db = new DBController();

$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
$user_id    = $_SESSION['user_id'];
$quantity   = 1;

if ($product_id > 0) {
    // In DB coloana se numeste member_id
    $query = "INSERT INTO tbl_cart (product_id, quantity, member_id) VALUES (?, ?, ?)";
    $db->updateDB($query, [$product_id, $quantity, $user_id]);
}

header("Location: index.php");
exit;
