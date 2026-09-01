<?php
require __DIR__ . '/db.php';

// Escapa texto para mostrarlo de forma segura en HTML.
function e(?string $v): string {
    return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
}

// Si viene ?editar=ID, cargamos ese estudiante para rellenar el formulario.
$editando = null;
if (isset($_GET['editar'])) {
    $stmt = $pdo->prepare("SELECT * FROM estudiantes WHERE id = :id");
    $stmt->execute(['id' => (int) $_GET['editar']]);
    $editando = $stmt->fetch();
}

// Listado completo (la parte "Leer" del CRUD).
$estudiantes = $pdo->query("SELECT * FROM estudiantes ORDER BY id DESC")->fetchAll();
$mensaje = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Estudiantes · CRUD PHP</title>
    <style>
        :root {
            --bg: #0f172a; --card: #1e293b; --accent: #6366f1;
            --accent-2: #22c55e; --danger: #ef4444; --text: #e2e8f0; --muted: #94a3b8;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0; font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
            background: var(--bg); color: var(--text); line-height: 1.5; padding: 2rem 1rem;
        }
        .wrap { max-width: 960px; margin: 0 auto; }
        h1 { margin: 0 0 .3rem; font-size: 1.7rem; }
        p.sub { margin: 0 0 1.8rem; color: var(--muted); }
        .card {
            background: var(--card); border: 1px solid #334155;
            border-radius: 14px; padding: 1.5rem; margin-bottom: 1.8rem;
        }
        .card h2 { margin: 0 0 1rem; font-size: 1.15rem; }
        form.grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        label { display: block; font-size: .8rem; color: var(--muted); margin-bottom: .35rem; }
        input {
            width: 100%; padding: .65rem .8rem; border-radius: 9px;
            border: 1px solid #475569; background: #0f172a; color: var(--text); font-size: .95rem;
        }
        input:focus { outline: 2px solid var(--accent); border-color: transparent; }
        .full { grid-column: 1 / -1; display: flex; gap: .7rem; }
        button {
            border: none; border-radius: 9px; padding: .7rem 1.3rem;
            font-size: .95rem; font-weight: 600; cursor: pointer; color: #fff;
        }
        .btn-primary { background: var(--accent); }
        .btn-ok { background: var(--accent-2); }
        .btn-danger { background: var(--danger); }
        .btn-ghost { background: #475569; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: .75rem .6rem; border-bottom: 1px solid #334155; font-size: .9rem; }
        th { color: var(--muted); font-weight: 600; text-transform: uppercase; font-size: .72rem; letter-spacing: .04em; }
        .acciones { display: flex; gap: .4rem; }
        .acciones a, .acciones button { padding: .4rem .7rem; font-size: .8rem; text-decoration: none; border-radius: 7px; }
        .alerta {
            background: #14532d; border: 1px solid #22c55e; color: #dcfce7;
            padding: .8rem 1rem; border-radius: 10px; margin-bottom: 1.5rem;
        }
        .vacio { text-align: center; color: var(--muted); padding: 2rem; }
        @media (max-width: 620px) { form.grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<div class="wrap">
    <h1>🎓 Registro de Estudiantes</h1>
    <p class="sub">CRUD en PHP + MySQL — desplegado en Railway</p>

    <?php if ($mensaje): ?>
        <div class="alerta"><?= e($mensaje) ?></div>
    <?php endif; ?>

    <!-- FORMULARIO: sirve para Crear y Actualizar -->
    <div class="card">
        <h2><?= $editando ? '✏️ Editar estudiante #' . e($editando['id']) : '➕ Nuevo estudiante' ?></h2>
        <form class="grid" action="acciones.php" method="post">
            <input type="hidden" name="accion" value="<?= $editando ? 'actualizar' : 'crear' ?>">
            <?php if ($editando): ?>
                <input type="hidden" name="id" value="<?= e($editando['id']) ?>">
            <?php endif; ?>

            <div>
                <label>Nombre completo</label>
                <input type="text" name="nombre" required maxlength="120"
                       value="<?= e($editando['nombre'] ?? '') ?>">
            </div>
            <div>
                <label>Correo electrónico</label>
                <input type="email" name="email" required maxlength="150"
                       value="<?= e($editando['email'] ?? '') ?>">
            </div>
            <div>
                <label>Edad</label>
                <input type="number" name="edad" required min="1" max="120"
                       value="<?= e($editando['edad'] ?? '') ?>">
            </div>
            <div>
                <label>Curso</label>
                <input type="text" name="curso" required maxlength="100"
                       value="<?= e($editando['curso'] ?? '') ?>">
            </div>

            <div class="full">
                <?php if ($editando): ?>
                    <button type="submit" class="btn-ok">Guardar cambios</button>
                    <a href="index.php"><button type="button" class="btn-ghost">Cancelar</button></a>
                <?php else: ?>
                    <button type="submit" class="btn-primary">Registrar</button>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- TABLA: imprime todos los datos registrados -->
    <div class="card">
        <h2>📋 Estudiantes registrados (<?= count($estudiantes) ?>)</h2>
        <?php if (!$estudiantes): ?>
            <div class="vacio">Todavía no hay estudiantes. ¡Registra el primero arriba!</div>
        <?php else: ?>
            <div style="overflow-x:auto">
            <table>
                <thead>
                    <tr>
                        <th>ID</th><th>Nombre</th><th>Email</th>
                        <th>Edad</th><th>Curso</th><th>Registrado</th><th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estudiantes as $est): ?>
                        <tr>
                            <td><?= e($est['id']) ?></td>
                            <td><?= e($est['nombre']) ?></td>
                            <td><?= e($est['email']) ?></td>
                            <td><?= e($est['edad']) ?></td>
                            <td><?= e($est['curso']) ?></td>
                            <td><?= e($est['creado_en']) ?></td>
                            <td>
                                <div class="acciones">
                                    <a href="index.php?editar=<?= e($est['id']) ?>" class="btn-primary">Editar</a>
                                    <form action="acciones.php" method="post"
                                          onsubmit="return confirm('¿Eliminar a <?= e($est['nombre']) ?>?');">
                                        <input type="hidden" name="accion" value="eliminar">
                                        <input type="hidden" name="id" value="<?= e($est['id']) ?>">
                                        <button type="submit" class="btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
