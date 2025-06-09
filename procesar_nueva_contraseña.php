<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $nueva_contrasena = password_hash($_POST['nueva_contrasena'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE token_recuperacion = ? AND token_expiracion > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $stmt = $conn->prepare("UPDATE usuarios SET contrasena = ?, token_recuperacion = NULL, token_expiracion = NULL WHERE token_recuperacion = ?");
        $stmt->bind_param("ss", $nueva_contrasena, $token);
        $stmt->execute();
        echo "Tu contraseña fue actualizada correctamente. <a href='ingreso.php'>Iniciar sesión</a>";
    } else {
        echo "Token inválido o expirado.";
    }
}
?>
