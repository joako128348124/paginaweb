<?php 
include("con_db.php");

$mensaje = "";

if (isset($_POST['register'])) {
    if (strlen($_POST['name']) >= 1 && strlen($_POST['email']) >= 1) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fechareg = date("d/m/y/H:i");
        $consulta = "INSERT INTO datos(nombre, email, fecha_reg) VALUES ('$name','$email','$fechareg')";
        $resultado = mysqli_query($conex, $consulta);
        if ($resultado) {
            $mensaje = "<div class='ok'>¡Te has inscripto correctamente!</div>";
        } else {
            $mensaje = "<div class='bad'>¡Ups ha ocurrido un error!</div>";
        }
    } else {
        $mensaje = "<div class='bad'>¡Por favor complete los campos!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Crear cuenta</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Inter', sans-serif;
      background: radial-gradient(circle at 30% 30%, #7c3aed, #1e1b4b);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px;
      color: #fff;
    }

    .form-container {
      background: #fff;
      color: #1e1e2f;
      border-radius: 20px;
      box-shadow: 0 20px 50px rgba(0,0,0,0.2);
      width: 100%;
      max-width: 450px;
      padding: 40px 35px;
      animation: fadeIn 0.8s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h2 {
      font-weight: 700;
      font-size: 2.2rem;
      text-align: center;
      color: #7c3aed;
      margin-bottom: 25px;
    }

    label {
      font-size: 0.95rem;
      font-weight: 600;
      display: block;
      margin-bottom: 8px;
      margin-top: 16px;
    }

    input[type="text"],
    input[type="email"] {
      width: 100%;
      padding: 14px 16px;
      font-size: 1rem;
      border: 2px solid #e0e0e0;
      border-radius: 12px;
      transition: all 0.3s ease;
    }

    input:focus {
      border-color: #7c3aed;
      box-shadow: 0 0 8px rgba(124, 58, 237, 0.4);
      outline: none;
    }

    .button {
      width: 100%;
      background: linear-gradient(135deg, #7c3aed, #4f46e5);
      color: white;
      border: none;
      padding: 16px;
      border-radius: 14px;
      font-weight: 600;
      font-size: 1.05rem;
      margin-top: 24px;
      cursor: pointer;
      transition: background 0.3s, box-shadow 0.3s;
    }

    .button:hover {
      background: linear-gradient(135deg, #5b21b6, #4338ca);
      box-shadow: 0 8px 20px rgba(91, 33, 182, 0.3);
    }

    .ok {
      background-color: #dcfce7;
      color: #166534;
      border: 1.5px solid #22c55e;
      padding: 14px 18px;
      border-radius: 12px;
      text-align: center;
      font-weight: 600;
      margin-bottom: 20px;
    }

    .bad {
      background-color: #fee2e2;
      border: 1.5px solid #ef4444;
      color: #b91c1c;
      padding: 14px 18px;
      border-radius: 12px;
      font-weight: 600;
      text-align: center;
      margin-bottom: 20px;
    }

    @media (max-width: 480px) {
      .form-container {
        padding: 32px 24px;
      }
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h2>Crear Cuenta</h2>
    <?= $mensaje ?>

    <form method="POST" autocomplete="off">
      <label for="name">Nombre</label>
      <input type="text" name="name" id="name" placeholder="Tu nombre completo" required />

      <label for="email">Correo Electrónico</label>
      <input type="email" name="email" id="email" placeholder="tucorreo@ejemplo.com" required />

      <button type="submit" name="register" class="button">Registrarse</button>
    </form>
  </div>

</body>
</html>
