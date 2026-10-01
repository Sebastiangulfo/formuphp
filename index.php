<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gestion de Productos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<!-- Encabezado con contexto -->
<header class="cabecera">
    <h1>🛒 Gestion de Productos</h1>
    <p>Registra, edita y administra el inventario de tu tienda. Cada producto puede tener sus propias variantes.</p>
</header>

<?php
// Estadisticas del inventario
$total    = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS n FROM productos"))['n'];
$unidades = mysqli_fetch_assoc(mysqli_query($con, "SELECT IFNULL(SUM(cantidad),0) AS s FROM productos"))['s'];
$valor    = mysqli_fetch_assoc(mysqli_query($con, "SELECT IFNULL(SUM(precio*cantidad),0) AS v FROM productos"))['v'];
?>

<!-- Tarjetas de resumen -->
<div class="tarjetas">
    <div class="tarjeta">
        <span class="numero"><?php echo $total; ?></span>
        <span class="texto">Productos</span>
    </div>
    <div class="tarjeta">
        <span class="numero"><?php echo $unidades; ?></span>
        <span class="texto">Unidades en stock</span>
    </div>
    <div class="tarjeta">
        <span class="numero">$<?php echo number_format($valor, 2); ?></span>
        <span class="texto">Valor del inventario</span>
    </div>
</div>

<!-- Formulario para agregar un producto -->
<h2>➕ Agregar nuevo producto</h2>
<form action="guardar.php" method="POST">
    <input type="text" name="nombre" placeholder="Nombre del producto" required>
    <input type="number" step="0.01" name="precio" placeholder="Precio" required>
    <input type="number" name="cantidad" placeholder="Cantidad" required>
    <button type="submit">Guardar producto</button>
</form>

<!-- Tabla que imprime todos los productos -->
<h2>📦 Lista de productos</h2>

<?php
$resultado = mysqli_query($con, "SELECT * FROM productos ORDER BY id DESC");

if (mysqli_num_rows($resultado) == 0) {
    echo "<p class='vacio'>Todavia no hay productos. ¡Agrega el primero arriba!</p>";
} else {
?>
<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Acciones</th>
    </tr>

    <?php
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td>" . $fila['id'] . "</td>";
        echo "<td>" . $fila['nombre'] . "</td>";
        echo "<td>$" . number_format($fila['precio'], 2) . "</td>";
        echo "<td>" . $fila['cantidad'] . "</td>";
        echo "<td>
                <a href='editar.php?id=" . $fila['id'] . "'>Editar</a>
                <a class='btn-variantes' href='variantes.php?producto_id=" . $fila['id'] . "'>Variantes</a>
                <a href='eliminar.php?id=" . $fila['id'] . "'>Borrar</a>
              </td>";
        echo "</tr>";
    }
    ?>
</table>
<?php } ?>

<footer class="pie">
    <p>Sistema de inventario · Hecho con PHP y MySQL</p>
</footer>

</body>
</html>
