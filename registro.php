<html>
    <head>
        <meta charset="UTF-8">
        <title>Agricultura de Precisión - Registrar Sesión</title>
    </head>
    <body>
        <?php
        if (isset($_REQUEST['registrar'])) {
            include 'basedatos/sesionBD.php';
            registrar($_GET['nombre'], $_GET['apellido'], $_GET['dni'], $_GET['contrasena']);
            if (iniciarSesion($_GET['nombre'], $_GET['contrasena'])) {
                ?>
                <span>Se ha podido registrar sesión exito!</span>
                <a href="index.php">Volver a Iniciar Sesion</a>
                <?php
            } else {
                ?>
                <h1>Registrar Sesión</h1>
                <span>No se ha podido registrar sesion!</span>
                <form action="registro.php">
                    <p>
                        <label for="nombre">Nombre: </label>
                        <input type="text" name="nombre">
                    </p>
                    <p>
                        <label for="apellido">Apellido: </label>
                        <input type="text" name="apellido">
                    </p>
                    <p>
                        <label for="dni">DNI: </label>
                        <input type="text" name="dni">
                    </p>
                    <p>
                        <label for="contrasena">Contraseña: </label>
                        <input type="text" name="contrasena">
                    </p>
                    <p>
                        <input type="submit" value="Registrarse" name="registrar">
                    </p>
                </form>
                <?php
            }
        }
        ?>
        <h1>Registrar Sesión</h1>
        <form action="registro.php">
            <p>
                <label for="nombre">Nombre: </label>
                <input type="text" name="nombre">
            </p>
            <p>
                <label for="apellido">Apellido: </label>
                <input type="text" name="apellido">
            </p>
            <p>
                <label for="dni">DNI: </label>
                <input type="text" name="dni">
            </p>
            <p>
                <label for="contrasena">Contraseña: </label>
                <input type="text" name="contrasena">
            </p>
            <p>
                <input type="submit" value="Registrarse" name="registrar">
            </p>
        </form>
    </body>
</html>