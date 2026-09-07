<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registro de estudiantes</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<h1>Registro de estudiantes</h1>

<!-- Formulario para agregar un estudiante -->
<form action="guardar.php" method="POST">
    <input type="text" name="nombre" placeholder="Nombre del producto" required>
    <input type="number" step="0.01" name="precio" placeholder="Precio" required>
    <input type="number" name="cantidad" placeholder="Cantidad" required>
    <button type="submit">Guardar</button>
</form>

<h2>estudiantes registrados</h2>

<!-- Tabla que imprime todos los estudiantes -->
<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Acciones</th>
    </tr>

    <?php
    $resultado = mysqli_query($con, "SELECT * FROM productos");

    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td>" . $fila['id'] . "</td>";
        echo "<td>" . $fila['nombre'] . "</td>";
        echo "<td>" . $fila['precio'] . "</td>";
        echo "<td>" . $fila['cantidad'] . "</td>";
        echo "<td>
                <a href='editar.php?id=" . $fila['id'] . "'>Editar</a>
                <a href='eliminar.php?id=" . $fila['id'] . "'>Borrar</a>
              </td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>
