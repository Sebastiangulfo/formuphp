<?php
// Guarda una variante: si viene un id la actualiza, si no la crea
include 'db.php';

$nombre = $_POST['nombre'];
$cantidad = $_POST['cantidad'];
$producto_id = $_POST['producto_id'];

if (isset($_POST['id']) && $_POST['id'] != "") {
    // Actualizar
    $id = $_POST['id'];
    mysqli_query($con, "UPDATE variantes SET nombre='$nombre', cantidad='$cantidad' WHERE id=$id");
} else {
    // Crear
    mysqli_query($con, "INSERT INTO variantes (producto_id, nombre, cantidad) VALUES ('$producto_id', '$nombre', '$cantidad')");
}

// Volver a la lista de variantes de ese producto
header("Location: variantes.php?producto_id=$producto_id");
?>
