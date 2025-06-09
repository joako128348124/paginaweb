<?php
require_once 'config.php'; // Incluye el Google Client ya configurado

if (isset($_GET['code'])) {
    // Intercambiar el código por un token de acceso
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);

    // Verificar si hay errores al obtener el token
    if (!isset($token['error'])) {
        // Establecer el token para futuras llamadas
        $google_client->setAccessToken($token['access_token']);

        // Obtener datos del perfil del usuario
        $google_service = new Google_Service_Oauth2($google_client);
        $user_info = $google_service->userinfo->get();

        // Variables útiles
        $email = $user_info->email;
        $nombre = $user_info->givenName;
        $apellido = $user_info->familyName;
        $foto = $user_info->picture;

        // Guardar los datos en sesión
        $_SESSION['usuario'] = $email;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['apellido'] = $apellido;
        $_SESSION['foto'] = $foto;
        $_SESSION['login_con_google'] = true;

        // Redirigir a la página principal o dashboard
        header('Location: accesocorrecto.php');
        exit();
    } else {
        echo "Error al obtener el token de acceso de Google.";
    }
} else {
    echo "No se recibió el parámetro 'code'.";
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';

// resto del código...
