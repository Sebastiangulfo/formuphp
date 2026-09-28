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
    <title>Eliminar variante</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<h1>¿Seguro que quieres borrar esta variante?</h1>

<a href="eliminar_variante.php?id=<?php echo $id; ?>&confirmar=si">Si, borrar</a>
<a href="variantes.php?producto_id=<?php echo $producto_id; ?>">No, volver</a>

</body>
</html>
