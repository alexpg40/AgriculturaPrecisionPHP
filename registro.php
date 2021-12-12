<html>
    <head>
        <meta charset="UTF-8">
        <title>Agricultura de Precisión - Registrar Sesión</title>
        <link rel="stylesheet" href="styles/registro.css"/>
    </head>
    <body>
        <?php
        if (isset($_REQUEST['registrar'])) {
            include 'basedatos/sesionBD.php';
            include 'scripts/validarRegistro.php';
            if (validarNombre($_GET['nombre']) && validarApellido($_GET['apellido']) && validarDNI($_GET['dni']) && validarContraseña($_GET['contrasena'])) {
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
                    <form>
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
            } else {
                ?>
                <h1>Registrar Sesión</h1>
                <form action="registro.php">
                    <?php
                    if (!validarNombre($_GET['nombre'])) {
                        print('<span class="registro__input--warning">El nombre debe tener una longitud entre 3 y 16 caracteres</span>');
                    }
                    ?>
                    <p>
                        <label for="nombre">Nombre: </label>
                        <?php
                            if(validarNombre($_GET['nombre'])){
                                $nombre = $_GET['nombre'];
                                print("<input type='text' name='nombre' value='$nombre'>");
                            } else{
                                print("<input type='text' name='nombre'>");
                            }
                        ?>
                    </p>
                    <?php
                    if (!validarApellido($_GET['apellido'])) {
                        print('<span class="registro__input--warning">El apellido debe tener una longitud entre 3 y 16 caracteres!</span>');
                    }
                    ?>
                    <p>
                        <label for="apellido">Apellido: </label>
                        <?php
                            if(validarApellido($_GET['apellido'])){
                                $apellido = $_GET['apellido'];
                                print("<input type='text' name='apellido' value='$apellido'>");
                            } else{
                                print("<input type='text' name='apellido'>");
                            }
                        ?>
                    </p>
                    <?php
                    if (!validarDNI($_GET['dni'])) {
                        print('<span class="registro__input--warning">El DNI debe tener una longitud de 9, 8 digitos y terminar con una letra mayuscula, y no existir en la base de datos</span>');
                    }
                    ?>
                    <p>
                        <label for="dni">DNI: </label>
                        <?php
                            if(validarDNI($_GET['dni'])){
                                $dni = $_GET['dni'];
                                print("<input type='text' name='dni' value='$dni'>");
                            } else{
                                print("<input type='text' name='dni'>");
                            }
                        ?>
                    </p>
                    <?php
                    if (!validarContraseña($_GET['contrasena'])) {
                        print('<span class="registro__input--warning">La contraseña debe tener una longitud entre 8 y 16 caracteres, al menos una mayuscula, una minuscula y un digito</span>');
                    }
                    ?>
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
        } else {
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
            <?php
        }
        ?>
    </body>
</html>