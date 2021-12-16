<?php
session_start();
include 'basedatos/sesionBD.php';
$roles = recuperarRoles($_SESSION['idUsuario']);
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Agricultura de Precisión - Menu</title>
        <link rel="stylesheet" href="styles/menu.css">
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
                <?php
                if (!isset($_REQUEST['opcion'])) {
                    if (in_array('Administrador', $roles)) {
                        $usuariosRoles = recuperarTodosUsuarios();
                        ?>
                        <div class="wrapper__admin">
                            <form action="editarUsuario.php">
                            <h1 class="wrapper__title" >Mostrar usuarios</h1>
                            <div class="wrapper__admin-header">
                                <div class="wrapper__admin-header-icon">
                                    Icono de perfil
                                </div>
                                <div class="wrapper__admin-header-id">
                                    IdUsuario
                                </div>
                                <div class="wrapper__admin-header-nombre">
                                    Nombre
                                </div>
                                <div class="wrapper__admin-header-apellido">
                                   Apellido 
                                </div>
                                <div class="wrapper__admin-header-dni">
                                    DNI   
                                </div>
                                <div class="wrapper__admin-header-roles">
                                    Roles
                                </div>
                                <div class="wrapper__admin-header-select">
                                    Seleccionar
                                </div>
                            </div>
                            <div class="wrapper__admin-users">
                                <?php
                                foreach ($usuariosRoles as $usuario) {
                                    ?>
                                    <div class="wrapper__admin-users-item">
                                        <div class="wrapper__admin-users-item-icon">
                                            <img src="img/loginProfile.png">
                                        </div>
                                        <div class="wrapper__admin-users-item-idUsuario">
                                            <?=$usuario[0]?>
                                        </div>
                                        <div class="wrapper__admin-users-item-nombre">
                                            <?=$usuario[1]?>
                                        </div>
                                        <div class="wrapper__admin-users-item-apellido">
                                            <?=$usuario[2]?>
                                        </div>
                                        <div class="wrapper__admin-users-item-dni">
                                            <?=$usuario[3]?>
                                        </div>
                                        <div class="wrapper__admin-users-item-roles">
                                            <?php
                                                $arrayRoles = $usuario[4];
                                                if(count($arrayRoles)>0){
                                                    ?>
                                                <select>
                                                <?php
                                                    foreach ($arrayRoles as $rol){
                                                        ?>
                                                        <option><?=$rol?></option>
                                                        <?php
                                                    } 
                                                    ?>
                                                </select>
                                                <?php
                                                } else{
                                                    print "No tiene roles asignados";
                                                }
                                            ?>
                                        </div>
                                        <div class="wrapper__admin-users-item-select">
                                            <button type="submit" value="<?=$usuario[0]?>" name="idUsuario">Editar usuario</button>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            </form>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </body>
</html>