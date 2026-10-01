<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Inventario</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="layout">

    <!-- Barra lateral para cambiar de seccion -->
    <aside class="sidebar">
        <div class="logo">🛒 MiTienda</div>
        <nav>
            <a href="#" class="nav-item activo" data-sec="inicio">🏠 Inicio</a>
            <a href="#" class="nav-item" data-sec="productos">📦 Productos</a>
            <a href="#" class="nav-item" data-sec="acerca">ℹ️ Acerca de</a>
        </nav>
    </aside>

    <!-- Contenido principal -->
    <main class="main">

        <?php
        // Estadisticas del inventario
        $total    = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS n FROM productos"))['n'];
        $unidades = mysqli_fetch_assoc(mysqli_query($con, "SELECT IFNULL(SUM(cantidad),0) AS s FROM productos"))['s'];
        $valor    = mysqli_fetch_assoc(mysqli_query($con, "SELECT IFNULL(SUM(precio*cantidad),0) AS v FROM productos"))['v'];
        ?>

        <!-- ===== Seccion INICIO ===== -->
        <section id="inicio" class="seccion activa">
            <h1>Panel de inventario</h1>
            <p class="intro">Bienvenido a tu sistema de gestion de productos. Aqui puedes ver un resumen general del inventario.</p>

            <div class="tarjetas">
                <div class="tarjeta">
                    <span class="icono">📦</span>
                    <span class="numero"><?php echo $total; ?></span>
                    <span class="texto">Productos</span>
                </div>
                <div class="tarjeta">
                    <span class="icono">🔢</span>
                    <span class="numero"><?php echo $unidades; ?></span>
                    <span class="texto">Unidades en stock</span>
                </div>
                <div class="tarjeta">
                    <span class="icono">💰</span>
                    <span class="numero">$<?php echo number_format($valor, 2); ?></span>
                    <span class="texto">Valor del inventario</span>
                </div>
            </div>
        </section>

        <!-- ===== Seccion PRODUCTOS ===== -->
        <section id="productos" class="seccion">
            <h1>Productos</h1>

            <div class="panel">
                <h2>➕ Agregar producto</h2>
                <form action="guardar.php" method="POST" class="fila">
                    <input type="text" name="nombre" placeholder="Nombre del producto" required>
                    <input type="number" step="0.01" name="precio" placeholder="Precio" required>
                    <input type="number" name="cantidad" placeholder="Cantidad" required>
                    <button type="submit">Guardar</button>
                </form>
            </div>

            <div class="panel">
                <h2>📋 Lista de productos</h2>
                <input type="text" id="buscador" placeholder="🔍 Buscar producto por nombre...">

                <table id="tabla">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resultado = mysqli_query($con, "SELECT * FROM productos ORDER BY id DESC");
                        while ($fila = mysqli_fetch_assoc($resultado)) {
                            echo "<tr>";
                            echo "<td>" . $fila['id'] . "</td>";
                            echo "<td>" . $fila['nombre'] . "</td>";
                            echo "<td>$" . number_format($fila['precio'], 2) . "</td>";
                            echo "<td>" . $fila['cantidad'] . "</td>";
                            echo "<td>
                                    <a href='editar.php?id=" . $fila['id'] . "'>Editar</a>
                                    <a class='btn-variantes' href='variantes.php?producto_id=" . $fila['id'] . "'>Variantes</a>
                                    <a class='btn-borrar' href='eliminar.php?id=" . $fila['id'] . "'>Borrar</a>
                                  </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <p id="sinResultados" class="vacio" style="display:none;">No se encontraron productos.</p>
            </div>
        </section>

        <!-- ===== Seccion ACERCA ===== -->
        <section id="acerca" class="seccion">
            <h1>Acerca de</h1>
            <div class="panel">
                <p>Esta es una aplicacion sencilla de inventario hecha con <strong>PHP</strong> y <strong>MySQL</strong>.</p>
                <p>Permite registrar productos, editarlos, borrarlos y administrar las <strong>variantes</strong> de cada uno (por ejemplo colores o tallas).</p>
                <p>Usa el buscador en la seccion de productos para encontrar un articulo rapido, y las tarjetas del inicio para ver el resumen del inventario.</p>
            </div>
        </section>

    </main>
</div>

<script>
// Cambiar entre secciones al hacer clic en el menu
var items = document.querySelectorAll('.nav-item');
items.forEach(function (item) {
    item.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('activo'));
        document.querySelectorAll('.seccion').forEach(s => s.classList.remove('activa'));
        item.classList.add('activo');
        document.getElementById(item.dataset.sec).classList.add('activa');
    });
});

// Buscador en vivo
var buscador = document.getElementById('buscador');
buscador.addEventListener('keyup', function () {
    var filtro = buscador.value.toLowerCase();
    var filas = document.querySelectorAll('#tabla tbody tr');
    var visibles = 0;
    filas.forEach(function (fila) {
        var nombre = fila.cells[1].textContent.toLowerCase();
        if (nombre.indexOf(filtro) > -1) {
            fila.style.display = '';
            visibles++;
        } else {
            fila.style.display = 'none';
        }
    });
    document.getElementById('sinResultados').style.display = (visibles === 0) ? 'block' : 'none';
});
</script>

</body>
</html>
