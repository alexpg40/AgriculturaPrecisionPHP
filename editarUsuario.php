<?php
session_start();
include 'basedatos/sesionBD.php';
$roles = recuperarRoles($_SESSION['idUsuario']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Agricultura de Precisión - Editar Usuario</title>
        <link rel="stylesheet" href="styles/editarUsuario.css">
    </head>
    <body>
        <div class="global_wrapper">
            <?php
            if (isset($_REQUEST['opcion'])) {
                if ($_REQUEST['opcion'] == 'logout') {
                    session_destroy();
                    header('Location: index.php');
                }
            }
            ?>
            <div class="sidebar">
                <navbar class="sidebar__navbar">
                    <ul class="sidebar__navbar-list">
                        <form action="menu.php">
                            <?php
                            if (in_array('Agricultor', $roles)) {
                                ?>
                                <li class="sidebar__navbar-list-item">
                                    Parcelas<button type="submit" value="parcela" name="opcion"/><img class="sidebar__navbar-list-item-icon" src="img/parcelaIcon.png" alt="icono de parcela"/>
                                </li>
                                <?php
                            }
                            ?>
                            <?php
                            if (in_array('Piloto', $roles)) {
                                ?>
                                <li class="sidebar__navbar-list-item">
                                    Trabajos<button type="submit" value="trabajo" name="opcion"/><img class="sidebar__navbar-list-item-icon" src="img/trabajosIcon.png" alt="icono de trabajo"/>    
                                </li>
                                <?php
                            }
                            ?>
                            <?php
                            if (in_array('Piloto', $roles)) {
                                ?>
                                <li class="sidebar__navbar-list-item">
                                    Drones<button type="submit" value="drones" name="opcion"/><img class="sidebar__navbar-list-item-icon" src="img/dronIcon.png" alt="icono de dron"/>
                                </li>
                                <?php
                            }
                            ?>
                            <?php
                            if (in_array('Administrador', $roles)) {
                                ?>
                                <li class="sidebar__navbar-list-item">
                                    Administrar Roles<button type="submit" value="roles" name="opcion"/><img class="sidebar__navbar-list-item-icon" src="img/adminIcon.png" alt="icono de roles"/>
                                </li>
                                <?php
                            }
                            ?>
                            <li class="sidebar__navbar-list-item">
                                Cerrar Sesion<button type="submit" value="logout" name="opcion"/><img class="sidebar__navbar-list-item-icon" src="img/logoutIcon.png" alt="icono de cerrar sesion"/>
                            </li>
                        </form>
                    </ul>
                </navbar>
                <div class="sidebar__welcome">
                    <a href="#" class="sidebar__welcome-link">
                        <img src="img/loginProfile.png" class="sidebar__welcome-profile"/></a>
                    <?php
                    $nombre = recuperarNombre($_SESSION['idUsuario']);
                    print("<h2 class='sidebar__welcome-greet'>Bienvenido, $nombre</h2>");
                    ?>
                </div>
            </div>
            <div class="wrapper">
                <h1 class="wrapper__title">Editar Usuario</h1>
                <div class="wrapper__usuario">
                    <?php
                    $usuario = recuperarUsuario($_REQUEST['idUsuario']);
                    ?>
                    <div class="wrapper__usuario-editar">
                        <div class="wrapper__usuario-icon">
                            <img src="img/loginProfile.png">
                        </div>
                        <form class="wrapper__usuario-form">
                            <p>
                                <label for="nombre">Nombre</label>
                                <input type="text" name=nombre value="<?= $usuario[1] ?>">
                            <lable for="editarNombre">Editar Nombre</lable>
                            <input type="checkbox" name="editarNombre">
                            </p>
                            <p>
                                <label for="apellido">Apellido: </label>
                                <input type="text" name=apellido value="<?= $usuario[2] ?>">
                            <lable for="editarApellido">Editar Apellido</lable>
                            <input type="checkbox" name="editarApellido">
                            </p>
                            <p>
                                <label for="email">Email: </label>
                                <input type="text" name=email value="<?= $usuario[2] ?>">
                            <lable for="editarEmail">Editar Email</lable>
                            <input type="checkbox" name="editarEmail">
                            </p>
                            <p>
                                <label for="dni">DNI: </label>
                                <input type="text" name=dni value="<?= $usuario[3] ?>">
                            <lable for="editarDNI">Editar DNI</lable>
                            <input type="checkbox" name="editarDNI">
                            </p>
                            <input class="wrapper__usuario-form-submit" type="submit" name="editar" value="Editar Usuario">
                        </form>
                    </div>
                    <form class="wrapper__usuario-ban">
                        <input type="submit" name="bannear" value="Eliminar de la Base de datos">
                        <input type="submit" name="bannear" value="Expulsar temporalmente">
                        <input type="submit" name="bannear" value="Contactar">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>