<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Agricultura de Precisión - Iniciar Sesion</title>
        <link rel="stylesheet" href="styles/index.css">
    </head>
    <body>
        <div class="wrapper">
            <img src="img/loginImage2.jpg" alt="" class="wrapper__image">
            <div class="wrapper__login">
            <?php
        if (isset($_REQUEST['iniciar'])) {
            include 'basedatos/sesionBD.php';
            $registrado = iniciarSesion($_GET['usuario'], $_GET['contrasena']);
            if ($registrado>0) {
                $_SESSION['idUsuario'] = $registrado;
                header("Location: menu.php");
            } else {
                ?>
                <h1>INICIAR SESIÓN</h1>
                <form action="index.php" class="wrapper__login-form">
                    <p>
                        <label for="usuario">Usuario: </label><input class="wrapper__login-form-input" type="text" name="usuario" id="usuario">
                    </p>
                    <p>
                        <label for="contrasena">Contraseña: </label><input class="wrapper__login-form-input" type="text" name="contcontrasena" id="contrasena">
                    </p>
                    <p class="wrapper__login-form-buttons">
                        <input class="wrapper__login-form-button" type="submit" name="iniciar" value="Iniciar Sesion">
                        <input class="wrapper__login-form-button" type="submit" name="registrar" value="Registrarse">
                    </p>
                </form>
                <span class="wrapper__login-error">Error! El usuario no esta registrado en la Base de Datos!</span>
                <?php
            }
        } else if (isset($_REQUEST['registrar'])) {
            header("Location: registro.php");
        } else {
            ?>
            <h1>INICIAR SESIÓN</h1>
            <form action="index.php">
                <p>
                    <label for="usuario">Usuario: </label><input type="text" name="usuario">
                </p>
                <p>
                    <label for="contrasena">Contraseña: </label><input type="text" name="contrasena">
                </p>
                <p>
                    <input class="wrapper__login-error-button" type="submit" name="iniciar" value="Iniciar Sesion">
                    <input class="wrapper__login-error-button" type="submit" name="registrar" value="Registrarse">
                </p>
            </form>
            <?php
        }
        ?>
            </div>
        </div>
    </body>
</html>
