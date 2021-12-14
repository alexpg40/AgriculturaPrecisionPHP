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
    <div class="sidebar">
        <navbar class="sidebar__navbar">
            <ul class="sidebar__navbar-list">
                <li class="sidebar__navbar-list-item">
                    <a class="sidebar__navbar-list-link" href="#">Parcelas<img class="sidebar__navbar-list-item-icon"src="img/parcelaIcon.png" alt="icono de parcela"/></a>
                </li>
                <li class="sidebar__navbar-list-item">
                <a class="sidebar__navbar-list-link" href="#">Trabajo<img class="sidebar__navbar-list-item-icon"src="img/trabajosIcon.png" alt="icono de parcela"/></a>
                </li>
                <li class="sidebar__navbar-list-item">
                <a class="sidebar__navbar-list-link" href="#">Drones<img class="sidebar__navbar-list-item-icon"src="img/dronIcon.png" alt="icono de parcela"/></a>
                </li>
                <li class="sidebar__navbar-list-item">
                <a class="sidebar__navbar-list-link" href="#">Cerrar Sesion<img class="sidebar__navbar-list-item-icon"src="img/logoutIcon.png" alt="icono de parcela"/></a>
                </li>
            </ul>
        </navbar>
        <div class="sidebar__welcome">
        <h2 class="sidebar__welcome-greet">Bienvenido</h2>
            <a href="#" class="sidebar__welcome-link">
            <img src="img/loginProfile.png" class="sidebar__welcome-profile"/></a>
        </div>
    </div>
</body>
</html>