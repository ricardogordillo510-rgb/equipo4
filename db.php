<?php
$host = 'localhost';
$db   = 'sistema_web';
$user = 'root';
$pass = ''; // Cambia esto según tu config
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
try {
     $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (\PDOException $e) {
     die("Error de conexión: " . $e->getMessage());
}
?>