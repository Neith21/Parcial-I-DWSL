<?php

include_once("./conf/conf.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : "";
    $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : "";

    $consulta = "SELECT * FROM usuario WHERE usuario='$usuario' AND contrasena='" . md5($contrasena) . "'";
    $ejecutar = mysqli_query($conexion, $consulta);

    if ($ejecutar->num_rows == 1) {
        session_start();
        while ($usuarioRegistrado = mysqli_fetch_assoc($ejecutar)) {
            $_SESSION["usuario"] = $usuarioRegistrado['nombre'];
            $_SESSION["rol"] = $usuarioRegistrado['rol'];
        }
        header("Location: ./admin/index.php");
        exit();
    } else {
        $error = "Inicio de sesión fallido";
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Login</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <style>
        @import url('https://fonts.googleapis.com/css?family=Inter:300');

        body {
            padding: 0;
            margin: 0;
            font-family: 'Inter', sans-serif;
        }

        .vid-container {
            position: relative;
            height: 100vh;
            overflow: hidden;
        }

        .bgvid.back {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -100;
        }

        .inner-container {
            width: 400px;
            height: 400px;
            position: absolute;
            top: calc(50vh - 200px);
            left: calc(50vw - 200px);
            overflow: hidden;
            border-radius: 7px;
        }

        .box {
            position: absolute;
            height: 100%;
            width: 100%;
            color: #fff;
            background: rgba(0, 0, 0, 0.28);
            padding: 30px 0px;
            border-radius: 7px;
        }

        .box h1 {
            text-align: center;
            margin: 30px 0;
            font-size: 30px;
        }

        .box input {
            display: block;
            width: 300px;
            margin: 20px auto;
            padding: 15px;
            background: rgba(0, 0, 0, 0.2);
            color: #fff;
            border-radius: 7px;
            border: 0;
        }

        input::placeholder {
            color: rgb(182, 171, 163);
        }

        .signup {
            color: rgb(182, 171, 163) !important;
        }

        .box input:focus,
        .box input:active,
        .box button:focus,
        .box button:active {
            outline: none;
        }

        .box button {
            background: #2d2f36;
            border: 0;
            color: #fff;
            padding: 10px;
            font-size: 20px;
            width: 330px;
            margin: 20px auto;
            display: block;
            cursor: pointer;
            border-radius: 7px;
        }

        .box button:active {
            background: #000000;
        }

        .box p {
            font-size: 14px;
            text-align: center;
        }

        .box p span {
            cursor: pointer;
            color: #666;
        }

        @media screen and (max-width: 986px) {
            .bgvid {
                height: 100px !important;
            }
        }

        @media screen and (min-width: 986px) {
            .bgvid.back {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="vid-container">
        <video id="Video1" class="bgvid back" autoplay="true" muted="muted" preload="auto" loop>
            <source src="videoLogin.mp4" type="video/mp4">
        </video>
        <div class="inner-container">
            <div class="box">
                <h1>Iniciar sesión</h1>
                <form action="" method="POST">
                    <input type="text" name="usuario" placeholder="Usuario" required />
                    <input type="password" name="contrasena" placeholder="Contraseña" required />
                    <button type="submit">Iniciar sesión</button>
                    <?php

                    if (isset($error)) {
                        echo '<p>' . htmlspecialchars($error) . '</p>';
                    }

                    ?>
                </form>
            </div>
        </div>
    </div>
    <script src="/js/main.js"></script>
</body>

</html>