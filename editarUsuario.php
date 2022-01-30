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
                } else if ($_REQUEST['opcion'] == 'roles'){
                    header('Location: menu.php');
                }
            } else{
                if(isset($_REQUEST['editar'])){
                    actualizarUsuario($_SESSION['editarUsuario'], $_REQUEST['nombre'], $_REQUEST['apellido'], $_REQUEST['email'], $_REQUEST['dni']);
                    header('Location: menu.php');
                } else if (isset($_REQUEST['bannear'])){
                    if($_REQUEST['bannear'] == 'Eliminar de la Base de datos'){
                        borrarUsuario($_SESSION['editarUsuario']);
                        header('Location: menu.php');
                    }
                } else if (isset($_REQUEST['submit_rol'])){
                    if($_REQUEST['submit_rol'] == 'Dar rol'){
                        darRol($_SESSION['editarUsuario'], $_REQUEST['rol']);
                        header('Location: menu.php');
                    } else if ($_REQUEST['submit_rol'] == 'Quitar rol'){
                        quitarRol($_SESSION['editarUsuario'], $_REQUEST['rol']);
                        header('Location: menu.php');
                    }
                }
            }
            ?>
            <div class="sidebar">
                <navbar class="sidebar__navbar">
                    <ul class="sidebar__navbar-list">
                        <form action="editarUsuario.php">
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
                    $_SESSION['editarUsuario'] = $_REQUEST['idUsuario'];
                    $usuario = recuperarUsuario($_REQUEST['idUsuario']);
                    ?>
                    <h2>Editar Atributos</h2>
                    <div class="wrapper__usuario-editar">
                        <div class="wrapper__usuario-icon">
                            <img src="img/loginProfile.png">
                        </div>
                        <form action="editarUsuario.php" class="wrapper__usuario-form">
                            <p>
                                <label for="nombre">Nombre: </label>
                                <input type="text" name=nombre value="<?= $usuario[1] ?>">
                            </p>
                            <p>
                                <label for="apellido">Apellido: </label>
                                <input type="text" name=apellido value="<?= $usuario[2] ?>">
                            </p>
                            <p>
                                <label for="email">Email: </label>
                                <input type="text" name=email value="<?= $usuario[5] ?>">
                            </p>
                            <p>
                                <label for="dni">DNI: </label>
                                <input type="text" name=dni value="<?= $usuario[3] ?>">
                            </p>
                            <input class="wrapper__usuario-form-submit" type="submit" name="editar" value="Editar Usuario">
                        </form>
                    </div>
                </div>
                <div class="gestion_roles">
                <h2>Gestion de roles</h2>
                <div class="wrapper__roles">
                    <div class="wrapper__roles-dar">
                        <h2 class="wrapper__roles-dar-title">Dar roles al usuario</h2>
                        <form class="wrapper__roles-form">
                        <select name="rol">
                            <?php
                            $rolesFaltan = recuperarRolesFalta($_REQUEST['idUsuario']);
                            foreach ($rolesFaltan as $rol){
                                ?>
                                    <option><?=$rol?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <input type="submit" name="submit_rol" value="Dar rol">
                        </form>
                    </div>
                    <form class="wrapper__usuario-ban">
                        <input type="submit" name="bannear" value="Eliminar de la Base de datos">
                    </form>
                    <div class="wrapper__roles-quitar">
                        <h2 class="wrapper__roles-dar-title">Quitar roles al usuario</h2>
                        <form class="wrapper__roles-form">
                        <select name="rol">
                            <?php
                            $rolesFaltan = recuperarRoles($_REQUEST['idUsuario']);
                            foreach ($rolesFaltan as $rol){
                                ?>
                                    <option><?=$rol?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <input type="submit" name="submit_rol" value="Quitar rol">
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </body>
</html>