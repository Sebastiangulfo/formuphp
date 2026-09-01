<?php
// Conexion a la base de datos
// Funciona en local y en Railway (lee las variables de Railway si existen)

$host = getenv('MYSQLHOST') ?: 'localhost';
$usuario = getenv('MYSQLUSER') ?: 'root';
$clave = getenv('MYSQLPASSWORD') ?: '';
$base = getenv('MYSQLDATABASE') ?: 'productos';
$puerto = getenv('MYSQLPORT') ?: 3306;

$con = mysqli_connect($host, $usuario, $clave, $base, $puerto);

if (!$con) {
    die("Error de conexion: " . mysqli_connect_error());
}

// Crea la tabla si todavia no existe
mysqli_query($con, "CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    precio DECIMAL(10,2),
    cantidad INT
)");
?>
