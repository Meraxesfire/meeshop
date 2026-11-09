# Meeshop

Aplicación de punto de venta en PHP y MySQL. Incluye una configuración de demo pública de solo lectura para enseñar el proyecto sin cambiar productos, stock o ventas.

## Demo pública en Railway

1. Sube el repositorio a GitHub y crea un proyecto nuevo en [Railway](https://railway.com/), desplegando el repositorio como servicio web. Railway detecta el `Dockerfile`.
2. Añade un servicio MySQL al proyecto.
3. En las variables del servicio web, referencia las variables del servicio MySQL y configura. Si Railway asignó al servicio de base de datos el nombre `MySQL`, las referencias tienen esta forma:

   ```text
   MYSQLHOST=${{MySQL.MYSQLHOST}}
   MYSQLPORT=${{MySQL.MYSQLPORT}}
   MYSQLUSER=${{MySQL.MYSQLUSER}}
   MYSQLPASSWORD=${{MySQL.MYSQLPASSWORD}}
   MYSQLDATABASE=${{MySQL.MYSQLDATABASE}}
   MEESHOP_DEMO_READ_ONLY=true
   ```

   Sustituye `MySQL` por el nombre exacto de tu servicio si es distinto. No guardes credenciales en el repositorio.
4. Conecta un cliente MySQL a la base de datos de Railway y ejecuta una vez [`db/init.sql`](./db/init.sql) para crear el esquema y cargar los datos ficticios.
5. Configura `/health.php` como ruta de healthcheck del servicio web. Cuando el despliegue esté activo, genera un dominio público desde la configuración de Railway.
6. La demo se puede abrir con el usuario `demo` y la contraseña `meeshop-demo`.

La imagen Docker activa por defecto el modo de solo lectura: oculta los controles de escritura y bloquea también las rutas de alta y actualización en el servidor. Mantén `MEESHOP_DEMO_READ_ONLY=true` en el entorno público. Los registros de la base de datos son inventados.

## Ejecución local

La aplicación ejecutada directamente con PHP sigue usando por defecto `localhost`, el usuario MySQL `root`, contraseña vacía y la base de datos `meeshop_test`. Importa [`db/init.sql`](./db/init.sql) en esa base de datos y sirve la carpeta con PHP/Apache. Para simular la demo pública, define `MEESHOP_DEMO_READ_ONLY=true` en el entorno local.
