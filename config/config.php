<?php

$host = "localhost";
$dbname = "consumer_db";
$user = "root";
$pass = "root"; // XAMPP Windows -> contraseña vacía

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error conexión: " . $e->getMessage());
}
