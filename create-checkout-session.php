<?php

session_start();
require_once 'vendor/autoload.php'; // Generat de Composer
require_once 'DBController.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Utilizator neautentificat']);
    exit;
}
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

\Stripe\Stripe::setApiKey($_ENV['STRIPE_KEY']);


$db = new DBController();
$member_id = (int)$_SESSION['user_id'];

$cart_items = $db->getDBResult(
    "SELECT p.name, p.price, c.quantity
     FROM tbl_cart c
     JOIN tbl_product p ON c.product_id = p.id
     WHERE c.member_id = ?",
    [$member_id]
);

if (empty($cart_items)) {
    http_response_code(400);
    echo json_encode(['error' => 'Cosul este gol']);
    exit;
}

$line_items = [];
foreach ($cart_items as $item) {
    $line_items[] = [
        'price_data' => [
            'currency' => 'usd',
            'product_data' => [
                'name' => $item['name'],
            ],
            'unit_amount' => $item['price'] * 100,
        ],
        'quantity' => $item['quantity'],
    ];
}

$DOMAIN = 'http://localhost:8888/proiect';

try {
    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $line_items,
        'mode' => 'payment',
        'success_url' => $DOMAIN . '/success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => $DOMAIN . '/cart.php',
    ]);

    header('Content-Type: application/json');
    echo json_encode(['id' => $checkout_session->id]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}