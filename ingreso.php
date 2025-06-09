<?php
session_start();

// Conexión a la base de datos
$conex = mysqli_connect("localhost", "root", "", "nusuario");
if (!$conex) {
    die("Error de conexión: " . mysqli_connect_error());
}

$usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';

// Buscar usuario por nombre de usuario
$sql = "SELECT * FROM registronuevo WHERE user = ?";
$stmt = mysqli_prepare($conex, $sql);
mysqli_stmt_bind_param($stmt, "s", $usuario);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $hashedPassword = $row['pass'];
    $email = $row['email'];

    // Verificar si existe clave temporal
    $sqlClaveTemp = "SELECT CLAVE_NUEVA FROM recuperar WHERE email = ? LIMIT 1";
    $stmtTemp = mysqli_prepare($conex, $sqlClaveTemp);
    mysqli_stmt_bind_param($stmtTemp, "s", $email);
    mysqli_stmt_execute($stmtTemp);
    $resTemp = mysqli_stmt_get_result($stmtTemp);

    if ($resTemp && mysqli_num_rows($resTemp) === 1) {
        $rowTemp = mysqli_fetch_assoc($resTemp);
        $claveTemporalHash = $rowTemp['CLAVE_NUEVA'];

        // Verificar si la clave ingresada es la clave temporal
        if (password_verify($password, $claveTemporalHash)) {
            $_SESSION['email'] = $email;
            $_SESSION['clave_temporal_usada'] = true;

            // Eliminar clave temporal (con consulta preparada)
            $stmtDel = mysqli_prepare($conex, "DELETE FROM recuperar WHERE email = ?");
            mysqli_stmt_bind_param($stmtDel, "s", $email);
            mysqli_stmt_execute($stmtDel);

            header("Location: cambiar_contrasena.php");
            exit();
        }
    }

    // Verificación de contraseña normal
    if (password_verify($password, $hashedPassword)) {
        $_SESSION["usuario"] = $usuario;
        header("Location: accesocorrecto.php");
        exit();
    }
}

// Si no se encuentra usuario o contraseña incorrecta
$_SESSION['error_login'] = "Usuario o contraseña incorrectos.";
header("Location: index.php");
exit();
?>