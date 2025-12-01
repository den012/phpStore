<?php
session_start();
require_once 'DBController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$db = new DBController();

$cart_id  = isset($_POST['cart_id']) ? (int)$_POST['cart_id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

if ($cart_id > 0) {
    if ($quantity > 0) {
        $query = "UPDATE tbl_cart SET quantity = ? WHERE id = ?";
        $db->updateDB($query, [$quantity, $cart_id]);
    } else {
        $query = "DELETE FROM tbl_cart WHERE id = ?";
        $db->updateDB($query, [$cart_id]);
    }
}

header("Location: cart.php");
exit;
