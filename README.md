🧾 Guía paso a paso para ejecutar el sistema web con login de Google
Esta guía explica cómo instalar y ejecutar un sistema web PHP en XAMPP, con autenticación mediante cuenta de Google usando OAuth 2.0.
✅ 1. Crear la base de datos

1. Abrir XAMPP y asegurarse de que los servicios Apache y MySQL estén activos.
2. Ingresar a phpMyAdmin desde el panel de XAMPP.
3. Crear una nueva base de datos llamada: nusuario
4. Ir a la pestaña Importar.
5. Seleccionar el archivo nusuario.sql que viene con el sistema.
6. Hacer clic en Continuar para importar las tablas.

📁 2. Copiar los archivos del sistema

1. Navegar a la carpeta de instalación de XAMPP (por defecto: C:\xampp\htdocs\).
2. Copiar allí todos los archivos del sistema, incluyendo:
   - index.php
   - config.php
   - Otros archivos .php necesarios (por ejemplo, alta.php, login.php, etc.)
   - El archivo composer.json si se usa login con Google.
3. Si el sistema está en una subcarpeta (por ejemplo, htdocs/miProyecto/), asegurarse de usar esa ruta para acceder después.

💡 Composer: Asegurarse de tener Composer instalado para manejar las dependencias del login con Google. En la terminal, desde la carpeta del proyecto, correr:
composer install

🔐 3. Configurar el login con Google (OAuth)

1. Ingresar a Google Cloud Console (https://console.cloud.google.com/).
2. Crear un nuevo proyecto o seleccionar uno existente.
3. Ir a APIs y servicios > Credenciales.
4. Crear un nuevo ID de cliente OAuth 2.0:
   - Tipo de aplicación: Aplicación web
   - URI de redirección autorizado: http://localhost/index.php
5. Copiar el Client ID y el Client Secret que te proporciona Google.

6. Abrir el archivo config.php en tu proyecto, y reemplazar las siguientes líneas con tus datos:

$client->setClientId("TU_CLIENT_ID_AQUÍ");
$client->setClientSecret("TU_CLIENT_SECRET_AQUÍ");

⚠️ Asegurate de mantener las comillas y no dejar espacios en blanco innecesarios.

🌐 4. Ejecutar el sistema

1. Iniciar los servicios Apache y MySQL en XAMPP si aún no lo hiciste.
2. Abrir un navegador web.
3. Ir a la siguiente URL: http://localhost/index.php
4. Desde la página de inicio, vas a poder:
   - Iniciar sesión con usuario y contraseña.
   - Registrarte como nuevo usuario.
   - Recuperar contraseña.
   - Iniciar sesión con Google (si la configuración es correcta).

