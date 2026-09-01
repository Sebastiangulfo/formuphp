# CRUD de Productos en PHP + MySQL

Proyecto sencillo con un formulario que registra productos e imprime todos los
datos en una tabla. Tiene CRUD (Crear, Leer, Actualizar, Borrar) y se conecta a
una base de datos MySQL. Desplegado en Railway.

🌐 En vivo: https://formuphp-cli-production.up.railway.app

## Archivos

- `index.php` — formulario de registro + tabla que imprime todos los productos
- `guardar.php` — crea o actualiza un producto
- `editar.php` — formulario para editar
- `eliminar.php` — borra un producto (pide confirmacion)
- `db.php` — conexion a la base de datos (local y Railway)
- `schema.sql` — crea la tabla `productos`
- `estilos.css` — estilos de la pagina

## Base de datos

La tabla `productos` tiene: id, nombre, precio y cantidad.
El archivo `db.php` ya crea la tabla solo si no existe, asi que funciona sin
pasos extra. Si quieres crearla a mano usa `schema.sql`.

## Correr en local

Necesitas PHP y MySQL. Crea una base llamada `productos` y luego:

```
php -S localhost:8000
```

Abre http://localhost:8000
