<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'vendor/autoload.php';

$google_client = new Google_Client();
$google_client->setClientId('4xxxxxxx-xxxxxxx');
$google_client->setClientSecret('xxxxxxx-xxxxxxx');

// Esta URI debe coincidir EXACTAMENTE con la configurada en Google Cloud Console
$google_client->setRedirectUri('http://localhost/accesocorrecto.php');

$google_client->addScope('email');
$google_client->addScope('profile');
