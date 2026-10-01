<?php
// Borra una variante, pidiendo confirmacion
include 'db.php';

$id = $_GET['id'];

// Buscamos la variante para saber a que producto volver
$res = mysqli_query($con, "SELECT * FROM variantes WHERE id=$id");
$variante = mysqli_fetch_assoc($res);
$producto_id = $variante['producto_id'];

// Si ya confirmo, se borra
if (isset($_GET['confirmar'])) {
    mysqli_query($con, "DELETE FROM variantes WHERE id=$id");
    header("Location: variantes.php?producto_id=$producto_id");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar variante</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="caja">
    <h1>🗑️ ¿Borrar esta variante?</h1>
    <p>Esta accion no se puede deshacer.</p>

    <a class="btn btn-rojo" href="eliminar_variante.php?id=<?php echo $id; ?>&confirmar=si">Si, borrar</a>
    <a class="btn" href="variantes.php?producto_id=<?php echo $producto_id; ?>">No, volver</a>
</div>

</body>
</html>
