<?php

/*** mysql hostname ***/
$hostname = 'localhost';
/*** mysql username ***/
$username = 'root';
/*** mysql password ***/
$password = 'root';
/*** baza de date ***/
$db = 'magazin2';
try {
    // Se creează o conexiune PDO
    $pdo = new PDO("mysql:host=$hostname;dbname=$db", $username, $password);

    // Setează modul de raportare a erorilor
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo 'Conectat la baza de date: ' . $db;

    // Aici poți adăuga cod suplimentar pentru manipularea bazei de date
} catch (PDOException $e) {
    echo 'Nu se poate conecta la baza de date: ' . $e->getMessage();
    exit();
}
// Conexiunea va fi închisă automat la finalul scriptului
