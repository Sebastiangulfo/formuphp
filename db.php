<?php
/**
 * Conexión a MySQL usando PDO.
 *
 * En Railway, al añadir el plugin de MySQL y referenciarlo en el servicio,
 * quedan disponibles estas variables de entorno:
 *   MYSQLHOST, MYSQLPORT, MYSQLUSER, MYSQLPASSWORD, MYSQLDATABASE
 * (o bien la URL completa MYSQL_URL).
 *
 * En local puedes definir esas mismas variables o cambiar los valores por defecto.
 */

// Permite usar la URL completa si está disponible (formato mysql://user:pass@host:port/db)
$mysqlUrl = getenv('MYSQL_URL') ?: getenv('DATABASE_URL');

if ($mysqlUrl) {
    $parts    = parse_url($mysqlUrl);
    $host     = $parts['host'] ?? 'localhost';
    $port     = $parts['port'] ?? 3306;
    $user     = $parts['user'] ?? 'root';
    $password = $parts['pass'] ?? '';
    $database = ltrim($parts['path'] ?? '/railway', '/');
} else {
    $host     = getenv('MYSQLHOST')     ?: getenv('DB_HOST') ?: 'localhost';
    $port     = getenv('MYSQLPORT')     ?: getenv('DB_PORT') ?: '3306';
    $user     = getenv('MYSQLUSER')     ?: getenv('DB_USER') ?: 'root';
    $password = getenv('MYSQLPASSWORD') ?: getenv('DB_PASSWORD') ?: '';
    $database = getenv('MYSQLDATABASE') ?: getenv('DB_NAME') ?: 'railway';
}

try {
    $dsn = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    exit('Error de conexión a la base de datos: ' . htmlspecialchars($e->getMessage()));
}

// Crea la tabla automáticamente en el primer arranque (evita pasos manuales en Railway).
$pdo->exec("
    CREATE TABLE IF NOT EXISTS estudiantes (
        id        INT AUTO_INCREMENT PRIMARY KEY,
        nombre    VARCHAR(120) NOT NULL,
        email     VARCHAR(150) NOT NULL,
        edad      INT NOT NULL,
        curso     VARCHAR(100) NOT NULL,
        creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");
