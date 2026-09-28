<?php
// Formulario para editar una variante
include 'db.php';

$id = $_GET['id'];
$res = mysqli_query($con, "SELECT * FROM variantes WHERE id=$id");
$variante = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar variante</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<h1>Editar variante</h1>

<form action="guardar_variante.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $variante['id']; ?>">
    <input type="hidden" name="producto_id" value="<?php echo $variante['producto_id']; ?>">
    <input type="text" name="nombre" value="<?php echo $variante['nombre']; ?>" required>
    <input type="number" name="cantidad" value="<?php echo $variante['cantidad']; ?>" required>
    <button type="submit">Actualizar</button>
</form>

<a href="variantes.php?producto_id=<?php echo $variante['producto_id']; ?>">Volver</a>

</body>
</html>
