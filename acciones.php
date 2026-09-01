<?php
/**
 * Procesa las operaciones CRUD (Crear, Actualizar, Eliminar).
 * Recibe datos por POST y redirige de vuelta a index.php.
 */
require __DIR__ . '/db.php';

$accion = $_POST['accion'] ?? '';

// Sanea y valida los campos del formulario.
function datosFormulario(): array {
    return [
        'nombre' => trim($_POST['nombre'] ?? ''),
        'email'  => trim($_POST['email'] ?? ''),
        'edad'   => (int) ($_POST['edad'] ?? 0),
        'curso'  => trim($_POST['curso'] ?? ''),
    ];
}

try {
    switch ($accion) {
        case 'crear':
            $d = datosFormulario();
            $stmt = $pdo->prepare(
                "INSERT INTO estudiantes (nombre, email, edad, curso)
                 VALUES (:nombre, :email, :edad, :curso)"
            );
            $stmt->execute($d);
            $mensaje = 'Estudiante registrado correctamente.';
            break;

        case 'actualizar':
            $id = (int) ($_POST['id'] ?? 0);
            $d  = datosFormulario();
            $stmt = $pdo->prepare(
                "UPDATE estudiantes
                 SET nombre = :nombre, email = :email, edad = :edad, curso = :curso
                 WHERE id = :id"
            );
            $stmt->execute($d + ['id' => $id]);
            $mensaje = 'Estudiante actualizado correctamente.';
            break;

        case 'eliminar':
            $id = (int) ($_POST['id'] ?? 0);
            $stmt = $pdo->prepare("DELETE FROM estudiantes WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $mensaje = 'Estudiante eliminado.';
            break;

        default:
            $mensaje = 'Acción no reconocida.';
    }
} catch (PDOException $e) {
    $mensaje = 'Error: ' . $e->getMessage();
}

// Redirige a la lista mostrando el mensaje.
header('Location: index.php?msg=' . urlencode($mensaje));
exit;
