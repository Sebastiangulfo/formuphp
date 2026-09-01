# Registro de Estudiantes — CRUD en PHP + MySQL

Aplicación web simple con un formulario y operaciones **CRUD** (Crear, Leer,
Actualizar, Eliminar) en PHP puro con PDO, conectada a **MySQL**. Lista para
desplegar en **Railway**.

## Archivos

| Archivo | Función |
|---|---|
| `db.php` | Conexión PDO a MySQL + creación automática de la tabla |
| `index.php` | Formulario + tabla que imprime los datos (Leer / Editar) |
| `acciones.php` | Procesa Crear, Actualizar y Eliminar |
| `Dockerfile` | Imagen PHP 8.2 + Apache para Railway |

## Desplegar en Railway (paso a paso)

1. **Crea un repositorio en GitHub** con estos archivos y súbelos:
   ```bash
   git init
   git add .
   git commit -m "CRUD PHP + MySQL"
   git branch -M main
   git remote add origin https://github.com/TU_USUARIO/formuphp.git
   git push -u origin main
   ```

2. **En Railway** → `New Project` → `Deploy from GitHub repo` → elige tu repo.
   Railway detecta el `Dockerfile` y construye la app.

3. **Añade la base de datos**: dentro del proyecto → `+ New` → `Database` → `Add MySQL`.

4. **Conecta las variables**: en el servicio de la app → pestaña `Variables` →
   `+ New Variable` → `Add Reference` y añade estas (desde el servicio MySQL):
   - `MYSQLHOST` = `${{MySQL.MYSQLHOST}}`
   - `MYSQLPORT` = `${{MySQL.MYSQLPORT}}`
   - `MYSQLUSER` = `${{MySQL.MYSQLUSER}}`
   - `MYSQLPASSWORD` = `${{MySQL.MYSQLPASSWORD}}`
   - `MYSQLDATABASE` = `${{MySQL.MYSQLDATABASE}}`

   > Alternativa: una sola variable `MYSQL_URL = ${{MySQL.MYSQL_URL}}`.

5. **Genera el dominio**: servicio de la app → `Settings` → `Networking` →
   `Generate Domain`. Abre la URL y ya tienes el CRUD funcionando.

La tabla `estudiantes` se crea sola en el primer arranque (ver `db.php`).

## Probar en local (opcional)

Con PHP instalado y un MySQL local:

```bash
MYSQLHOST=localhost MYSQLUSER=root MYSQLPASSWORD=tu_pass MYSQLDATABASE=railway \
  php -S localhost:8000
```

Luego abre http://localhost:8000
