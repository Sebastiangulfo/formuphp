<?php
// Muestra las variantes de un producto y permite agregar nuevas
include 'db.php';

$producto_id = $_GET['producto_id'];

// Datos del producto al que pertenecen las variantes
$res = mysqli_query($con, "SELECT * FROM productos WHERE id=$producto_id");
$producto = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Variantes</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="caja">
    <h1>🎨 Variantes de: <?php echo $producto['nombre']; ?></h1>

    <!-- Formulario para agregar una variante -->
    <form action="guardar_variante.php" method="POST">
        <input type="hidden" name="producto_id" value="<?php echo $producto_id; ?>">
        <input type="text" name="nombre" placeholder="Nombre de la variante (ej: Rojo talla M)" required>
        <input type="number" name="cantidad" placeholder="Cantidad" required>
        <button type="submit">Agregar variante</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $variantes = mysqli_query($con, "SELECT * FROM variantes WHERE producto_id=$producto_id");
            while ($v = mysqli_fetch_assoc($variantes)) {
                echo "<tr>";
                echo "<td>" . $v['id'] . "</td>";
                echo "<td>" . $v['nombre'] . "</td>";
                echo "<td>" . $v['cantidad'] . "</td>";
                echo "<td>
                        <a href='editar_variante.php?id=" . $v['id'] . "'>Editar</a>
                        <a class='btn-borrar' href='eliminar_variante.php?id=" . $v['id'] . "'>Borrar</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <a class="volver" href="index.php">← Volver a productos</a>
</div>

</body>
</html>
