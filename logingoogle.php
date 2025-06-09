<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';

if (!isset($_GET['code'])) {
    die("No se recibió el parámetro 'code'.");
}

// Obtener token de acceso con el código que envió Google
$token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);

// Verificar si hubo error
if (isset($token['error'])) {
    die("Error al obtener token: " . htmlspecialchars($token['error_description']));
}

$google_client->setAccessToken($token['access_token']);

// Obtener información del usuario
$google_service = new Google_Service_Oauth2($google_client);
$user_info = $google_service->userinfo->get();

session_start();
$_SESSION['usuario'] = $user_info->email;
$_SESSION['nombre'] = $user_info->givenName;
$_SESSION['apellido'] = $user_info->familyName;
$_SESSION['foto'] = $user_info->picture;
$_SESSION['login_con_google'] = true;

// Redirigir a página de éxito
header("Location: accesocorrecto.php");
exit();
