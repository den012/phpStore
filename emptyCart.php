<?php
session_start();
require_once 'DBController.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$db = new DBController();
$member_id = $_SESSION['user_id'];
// Golim coșul
$db->updateDB("DELETE FROM tbl_cart WHERE member_id = ?", [$member_id]);
header("Location: cart.php");
exit;
