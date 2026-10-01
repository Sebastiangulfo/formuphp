<?php
// Borra un producto, pero primero pide confirmacion
include 'db.php';

$id = $_GET['id'];

// Si ya confirmo, se borra
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Producto</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="caja">
    <h1>🗑️ ¿Borrar este producto?</h1>
    <p>Esta accion no se puede deshacer.</p>

    <a class="btn btn-rojo" href="eliminar.php?id=<?php echo $id; ?>&confirmar=si">Si, borrar</a>
    <a class="btn" href="index.php">No, volver</a>
</div>

</body>
</html>
