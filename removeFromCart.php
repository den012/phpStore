<?php
session_start();
require_once 'DBController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['cart_id'])) {
    header("Location: cart.php");
    exit;
}

$cart_id = (int)$_GET['cart_id'];   // id din tbl_cart
$user_id = (int)$_SESSION['user_id'];

$db = new DBController();

// stergem DOAR randul selectat, din cosul acestui user
$query = "DELETE FROM tbl_cart WHERE id = ? AND member_id = ? LIMIT 1";
$db->updateDB($query, [$cart_id, $user_id]);

header("Location: cart.php");
exit;
