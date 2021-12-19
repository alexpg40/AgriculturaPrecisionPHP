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
                registrar($_GET['nombre'], $_GET['apellido'], $_GET['dni'], $_GET['contrasena'], $_GET['email']);
                if (iniciarSesion($_GET['nombre'], $_GET['contrasena'])) {
                    ?>
                    <div class="volver">
                    <span>Se ha podido registrar sesión exito!</span>
                    <a href="index.php">Volver a Iniciar Sesion</a>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="wrapper">
            <img src="img/loginImage2.jpg" alt="" class="wrapper__image">
            <div class="wrapper__registro">
            <h1>REGISTRAR SESIÓN</h1>
            <form action="registro.php" class="wrapper__registro-form">
                <p>
                    <label for="nombre">Nombre: </label>
                    <input type="text" class="wrapper__registro-form-input" name="nombre">
                </p>
                <p>
                    <label for="apellido">Apellido: </label>
                    <input type="text" class="wrapper__registro-form-input" name="apellido">
                </p>
                <p>
                    <label for="dni">DNI: </label>
                    <input type="text" class="wrapper__registro-form-input" name="dni">
                </p>
                <p>
                    <label for="email">Email: </label>
                    <input type="text" class="wrapper__registro-form-input" name="email">
                </p>
                <p>
                    <label for="contrasena">Contraseña: </label>
                    <input type="text" class="wrapper__registro-form-input" name="contrasena">
                </p>
                <p class="wrapper__registro-form-buttons">
                    <input type="submit" class="wrapper__registro-form-button" value="Registrarse" name="registrar">
                </p>
            </form>
            </div>
            </div>
                    <?php
                }
            } else {
                ?>
                <div class="wrapper">
                    <img src="img/loginImage2.jpg" alt="" class="wrapper__image">
                    <div class="wrapper__registro">
                    <h1>REGISTRAR SESIÓN</h1>
                    <form action="registro.php" class="wrapper__registro-form">
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
                                print("<input type='text' class='wrapper__registro-form-input' name='nombre' value='$nombre'>");
                            } else{
                                print("<input type='text' class='wrapper__registro-form-input' name='nombre'>");
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
                                print("<input type='text' class='wrapper__registro-form-input' name='apellido' value='$apellido'>");
                            } else{
                                print("<input type='text' class='wrapper__registro-form-input' name='apellido'>");
                            }
                        ?>
                    </p>
                    <?php
                    if (!validarDNI($_GET['dni'])) {
                        print('<span class="registro__input--warning">El DNI debe tener 8 digitos y terminar con una letra mayuscula, y no existir en la base de datos</span>');
                    }
                    ?>
                    <p>
                        <label for="dni">DNI: </label>
                        <?php
                            if(validarDNI($_GET['dni'])){
                                $dni = $_GET['dni'];
                                print("<input type='text' class='wrapper__registro-form-input' name='dni' value='$dni'>");
                            } else{
                                print("<input type='text' class='wrapper__registro-form-input' name='dni'>");
                            }
                        ?>
                    </p>
                    <?php
                    if(!validarEmail($_GET['email'])){
                        print('<span class="registro__input--warning">El formato de correo electrónico no es válido</span>');
                    }
                    ?>
                    <p>
                        <label for="email">Email: </label>
                        <?php
                            if(validarEmail($_GET['email'])){
                                $email = $_GET['email'];
                                print("<input type='text' class='wrapper__registro-form-input' name='email' value='$email'");
                            } else{
                                print("<input type='text' class='wrapper__registro-form-input' name='email'>");
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
                        <input type="text" class="wrapper__registro-form-input" name="contrasena">
                    </p>
                    <p class="wrapper__registro-form-buttons">
                        <input type="submit" class="wrapper__registro-form-button" value="Registrarse" name="registrar">
                    </p>
                </form>
                </div>
                </div>  
                <?php
            }
        } else {
            ?>
            <div class="wrapper">
            <img src="img/loginImage2.jpg" alt="" class="wrapper__image">
            <div class="wrapper__registro">
            <h1>REGISTRAR SESIÓN</h1>
            <form action="registro.php" class="wrapper__registro-form">
                <p>
                    <label for="nombre">Nombre: </label>
                    <input type="text" class="wrapper__registro-form-input" name="nombre">
                </p>
                <p>
                    <label for="apellido">Apellido: </label>
                    <input type="text" class="wrapper__registro-form-input" name="apellido">
                </p>
                <p>
                    <label for="dni">DNI: </label>
                    <input type="text" class="wrapper__registro-form-input" name="dni">
                </p>
                <p>
                    <label for="email">Email: </label>
                    <input type="text" class="wrapper__registro-form-input" name="email">
                </p>
                <p>
                    <label for="contrasena">Contraseña: </label>
                    <input type="text" class="wrapper__registro-form-input" name="contrasena">
                </p>
                <p class="wrapper__registro-form-buttons">
                    <input type="submit" class="wrapper__registro-form-button" value="Registrarse" name="registrar">
                </p>
            </form>
            </div>
            </div>
            <?php
        }
        ?>
    </body>
</html>