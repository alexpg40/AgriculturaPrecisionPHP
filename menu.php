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
        <?php
        if(isset($_REQUEST['logout'])){
            session_destroy();
            header('Location: index.php');
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
                                Parcelas<button type="submit" value="parcela" name="parcela"/><img class="sidebar__navbar-list-item-icon" src="img/parcelaIcon.png" alt="icono de parcela"/>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (in_array('Piloto', $roles)) {
                            ?>
                            <li class="sidebar__navbar-list-item">
                                Trabajos<button type="submit" value="trabajo" name="trabajo"/><img class="sidebar__navbar-list-item-icon" src="img/trabajosIcon.png" alt="icono de trabajo"/>    
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (in_array('Piloto', $roles)) {
                            ?>
                            <li class="sidebar__navbar-list-item">
                                Drones<button type="submit" value="drones" name="dron"/><img class="sidebar__navbar-list-item-icon" src="img/dronIcon.png" alt="icono de dron"/>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (in_array('Administrador', $roles)) {
                            ?>
                            <li class="sidebar__navbar-list-item">
                                Administrar Roles<button type="submit" value="roles" name="roles"/><img class="sidebar__navbar-list-item-icon" src="img/dronIcon.png" alt="icono de roles"/>
                            </li>
                            <?php
                        }
                        ?>
                        <li class="sidebar__navbar-list-item">
                            Cerrar Sesion<button type="submit" value="logout" name="logout"/><img class="sidebar__navbar-list-item-icon" src="img/logoutIcon.png" alt="icono de cerrar sesion"/>
                        </li>
                    </form>
                </ul>
            </navbar>
            <div class="sidebar__welcome">
                <a href="#" class="sidebar__welcome-link">
                    <img src="img/loginProfile.png" class="sidebar__welcome-profile"/></a>
                    <?php
                    include 'sesionBD.php';
                    $nombre = recuperarNombre($_SESSION['idUsuario']);
                    print("<h2 class='sidebar__welcome-greet'>Bienvenido, $nombre</h2>");
                    ?>
            </div>
        </div>
    </body>
</html>