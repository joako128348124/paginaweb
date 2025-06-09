<?php
$mensaje = '';
$mostrarFormulario = false;

// Conectar a la base de datos
$conex = mysqli_connect("localhost", "root", "", "nusuario");
if (!$conex) {
    die("Error al conectar con la base de datos");
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['e']) && !empty($_GET['t'])) {
    $email = mysqli_real_escape_string($conex, $_GET['e']);
    $token = mysqli_real_escape_string($conex, $_GET['t']);

    $consulta = "SELECT * FROM recuperar WHERE email='$email' AND token='$token' LIMIT 1";
    $resultado = mysqli_query($conex, $consulta);

    if (mysqli_num_rows($resultado) === 1) {
        $registro = mysqli_fetch_assoc($resultado);
        $mostrarFormulario = true;
    } else {
        $mensaje = "<div class='error'>El enlace no es válido o ya fue usado.</div>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email']) && !empty($_POST['token']) && !empty($_POST['clave_temporal']) && !empty($_POST['nueva_clave'])) {
    $email = mysqli_real_escape_string($conex, $_POST['email']);
    $token = mysqli_real_escape_string($conex, $_POST['token']);
    $clave_temporal_ingresada = mysqli_real_escape_string($conex, $_POST['clave_temporal']);
    $nueva_clave = mysqli_real_escape_string($conex, $_POST['nueva_clave']);

    $consulta = "SELECT * FROM recuperar WHERE email='$email' AND token='$token' LIMIT 1";
    $resultado = mysqli_query($conex, $consulta);

    if (mysqli_num_rows($resultado) === 1) {
        $registro = mysqli_fetch_assoc($resultado);
        if ($registro['CLAVE_NUEVA'] === $clave_temporal_ingresada) {
            $clave_cifrada = password_hash($nueva_clave, PASSWORD_DEFAULT);

            // Actualizar contraseña en tabla de usuarios (usando 'pass')
            $actualizar = "UPDATE registronuevo SET pass='$clave_cifrada' WHERE email='$email'";
            if (mysqli_query($conex, $actualizar)) {
                // Borrar el registro de recuperación
                mysqli_query($conex, "DELETE FROM recuperar WHERE email='$email'");

                echo '
                <div class="ok">
                    ✅ Contraseña actualizada con éxito<br><br>
                    Redirigiendo al inicio de sesión...
                    <div class="loader"></div>
                </div>
                <style>
                    .ok {
                        background-color: #e8f5e9;
                        color: #2e7d32;
                        padding: 30px;
                        border-radius: 12px;
                        text-align: center;
                        font-size: 1.1rem;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                        margin: 60px auto;
                        max-width: 500px;
                        font-family: Arial, sans-serif;
                    }
                    .loader {
                        margin: 20px auto 0;
                        border: 5px solid #c8e6c9;
                        border-top: 5px solid #2e7d32;
                        border-radius: 50%;
                        width: 40px;
                        height: 40px;
                        animation: spin 1s linear infinite;
                    }
                    @keyframes spin {
                        0% { transform: rotate(0deg); }
                        100% { transform: rotate(360deg); }
                    }
                </style>
                <script>
                    setTimeout(function() {
                        window.location.href = "ingreso.php";
                    }, 4000);
                </script>';
                exit;
            } else {
                $mensaje = "<div class='error'>Error al actualizar la contraseña: " . mysqli_error($conex) . "</div>";
            }
        } else {
            $mensaje = "<div class='error'>La clave temporal es incorrecta.</div>";
            $mostrarFormulario = true;
        }
    } else {
        $mensaje = "<div class='error'>Datos inválidos o el enlace ha expirado.</div>";
    }
}

mysqli_close($conex);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Clave Temporal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background: #f1f5f9;
            font-family: Arial, sans-serif;
            padding: 40px;
            display: flex;
            justify-content: center;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #1e293b;
        }
        input {
            width: 100%;
            padding: 14px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 1rem;
        }
        input[type="submit"] {
            background: #0ea5e9;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #0284c7;
        }
        .ok, .error {
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            text-align: center;
        }
        .ok {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        .error {
            background-color: #ffebee;
            color: #c62828;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Cambiar Contraseña</h2>

        <?php if ($mostrarFormulario): ?>
        <form action="" method="POST">
            <input type="hidden" name="email" value="<?= htmlspecialchars($_GET['e']) ?>">
            <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['t']) ?>">

            <input type="text" name="clave_temporal" placeholder="Clave temporal" required>
            <input type="password" name="nueva_clave" placeholder="Nueva contraseña" required>
            <input type="submit" value="Actualizar contraseña">
        </form>
        <?php endif; ?>

        <?= $mensaje ?>
    </div>
</body>
</html>
