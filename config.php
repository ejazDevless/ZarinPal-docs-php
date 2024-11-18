<?php
// Written and developed by erfan Asadi
$host = "localhost";
$usernamedb = "-----_---";
$passworddb = "---------";
$dbname = "-----_---";
$Merchent_ID = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
$callback = 'https://example.com/VerifyPayment.php';
$sandbox = false;
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $usernamedb, $passworddb);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getCode());
}
