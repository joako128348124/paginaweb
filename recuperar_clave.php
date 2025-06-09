<?php
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email'])) {
    $conex = mysqli_connect("localhost", "root", "", "nusuario");

    if (!$conex) {
        die("Error al conectar con la base de datos");
    }

    $email = mysqli_real_escape_string($conex, $_POST['email']);
    $consulta = "SELECT * FROM registronuevo WHERE email='$email' LIMIT 1";
    $resultado = mysqli_query($conex, $consulta);
    $usuario = mysqli_fetch_assoc($resultado);

    if (!$usuario) {
        $mensaje = "<div class='error'>El correo ingresado no está registrado.</div>";
    } else {
        // Generar clave temporal y token
        $clave_nueva = rand(10000000, 99999999);
        $token = md5($email . time() . rand(1000, 9999));

        // Insertar o actualizar en la tabla recuperar
        $insertar = "INSERT INTO recuperar (email, token, clave_nueva, fecha_alta)
                     VALUES ('$email', '$token', '$clave_nueva', NOW())
                     ON DUPLICATE KEY UPDATE token='$token', clave_nueva='$clave_nueva', fecha_alta=NOW()";

        mysqli_query($conex, $insertar);

        $link = "http://localhost:/recuperar_clave_confirmar.php?e=$email&t=$token";

        // Mostrar mensaje simulado (en producción, se envía por mail)
        $mensaje = "
        <div class='ok'>
            Se generó una nueva contraseña temporal.<br><br>
            <strong>Clave temporal:</strong> <code>$clave_nueva</code><br>
            <strong>Link de confirmación:</strong><br>
            <a href='$link'>$link</a><br><br>
            Usá este enlace para activar tu nueva contraseña.
        </div>";
    }

    mysqli_close($conex);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background: #e0e7ff;
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
            color: #3f3d56;
        }
        input[type="email"] {
            width: 100%;
            padding: 14px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 1rem;
        }
        input[type="submit"] {
            width: 100%;
            padding: 14px;
            background: #4f46e5;
            border: none;
            color: white;
            font-weight: bold;
            font-size: 1rem;
            border-radius: 10px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #4338ca;
        }
        .ok {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            text-align: center;
        }
        .error {
            background-color: #ffebee;
            color: #c62828;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Recuperar Contraseña</h2>
        <form action="" method="POST">
            <input type="email" name="email" placeholder="Tu correo electrónico" required>
            <input type="submit" value="Enviar Clave Temporal">
        </form>
        <?= $mensaje ?>
    </div>
</body>
</html>
