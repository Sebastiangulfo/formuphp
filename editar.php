<?php
// Muestra el formulario con los datos del producto para editarlo
include 'db.php';

$id = $_GET['id'];
$resultado = mysqli_query($con, "SELECT * FROM productos WHERE id=$id");
$producto = mysqli_fetch_assoc($resultado);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="caja">
    <h1>✏️ Editar producto</h1>

    <form action="guardar.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
        <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required>
        <input type="number" step="0.01" name="precio" value="<?php echo $producto['precio']; ?>" required>
        <input type="number" name="cantidad" value="<?php echo $producto['cantidad']; ?>" required>
        <button type="submit">Actualizar</button>
    </form>

    <a class="volver" href="index.php">← Volver a productos</a>
</div>

</body>
</html>
