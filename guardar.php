<?php
// Guarda un producto: si viene un id lo actualiza, si no lo crea nuevo
include 'db.php';

$nombre = $_POST['nombre'];
$precio = $_POST['precio'];
$cantidad = $_POST['cantidad'];

if (isset($_POST['id']) && $_POST['id'] != "") {
    // Actualizar
    $id = $_POST['id'];
    mysqli_query($con, "UPDATE productos SET nombre='$nombre', precio='$precio', cantidad='$cantidad' WHERE id=$id");
} else {
    // Crear
    mysqli_query($con, "INSERT INTO productos (nombre, precio, cantidad) VALUES ('$nombre', '$precio', '$cantidad')");
}

// Volver a la pagina principal
header("Location: index.php");
?>
