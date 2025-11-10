<?php

$host = "localhost";
$dbname = "servirt_consumer";
$user = "servirt_consumer";
$pass = "7ckngMad"; // XAMPP Windows -> contraseña vacía

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error conexión: " . $e->getMessage());
}
