<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
            if ($registrado) {
                header("Location: menu.php");
            } else {
                ?>
                <h1>INICIAR SESIÓN</h1>
                <span class="warning">Error! El usuario no esta registrado en la Base de Datos!</span>
                <form action="index.php">
                    <p>
                        <label for="usuario">Usuario: </label><input type="text" name="usuario" id="usuario">
                    </p>
                    <p>
                        <label for="contrasena">Contraseña: </label><input type="text" name="contrasena" id="contrasena">
                    </p>
                    <p>
                        <input type="submit" name="iniciar" value="Iniciar Sesion">
                        <input type="submit" name="registrar" value="Registrarse">
                    </p>
                </form>
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
                    <input type="submit" name="iniciar" value="Iniciar Sesion">
                    <input type="submit" name="registrar" value="Registrarse">
                </p>
            </form>
            <?php
        }
        ?>
            </div>
        </div>
    </body>
</html>
