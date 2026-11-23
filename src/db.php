<?php
// ==============================================================================
// ARCHIVO: src/db.php
// Conexión PDO a MariaDB mediante TCP/IP (puerto 3306)
// ==============================================================================

$host = getenv('DB_HOST') ?: '127.0.0.1';
$dbname = getenv('DB_NAME') ?: 'empresa';
$user = getenv('DB_USER') ?: 'alumno_daw';
$pass = getenv('DB_PASSWORD') ?: 'password_segura_123';

try {
    $pdo = new PDO("mysql:host=$host;port=3306;dbname=$dbname;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    return $pdo;
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage() . "\n";
    exit(1);
}
?>
