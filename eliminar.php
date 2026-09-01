<?php
// Borra un producto, pero primero pide confirmacion
include 'db.php';

$id = $_GET['id'];

// Si el usuario ya confirmo, se borra
if (isset($_GET['confirmar'])) {
    mysqli_query($con, "DELETE FROM productos WHERE id=$id");
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Eliminar Producto</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<h1>¿Seguro que quieres borrar este producto?</h1>

<a href="eliminar.php?id=<?php echo $id; ?>&confirmar=si">Si, borrar</a>
<a href="index.php">No, volver</a>

</body>
</html>
