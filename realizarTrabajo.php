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
    <script src="javascript/realizarTrabajo.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <script src='https://unpkg.com/@turf/turf@6/turf.min.js'></script>
    <link rel="stylesheet" href="styles/realizarTrabajo.css">
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
                    <?php
                    if (isset($_REQUEST['programarParcela'])) {
                        insertarTrabajo($_REQUEST['tipoTrabajo'], $_REQUEST['piloto'], $_SESSION['idUsuario'], $_REQUEST['programarParcela']);
                    } else if (isset($_REQUEST['eliminar_parcela'])) {
                        eliminarParcela($_REQUEST['seleccionar']);
                    } else if (isset($_FILES['crear_parcela']['name'])) {
                        $directorio = 'ficheros/recintos/';
                        $fichero = $directorio . (string) time() . 'recintos.gml';
                        move_uploaded_file($_FILES['crear_parcela']['tmp_name'], $fichero);
                        include 'scripts/funcionesVarias.php';
                        $parcela = leerPuntosXML($fichero);
                        insertarParcela($parcela, $_SESSION['idUsuario']);
                    }
                    ?>
                    <form action="menu.php">
                        <?php
                        if (in_array('Agricultor', $roles)) {
                        ?>
                            <li class="sidebar__navbar-list-item">
                                Parcelas<button type="submit" value="parcela" name="opcion"><img class="sidebar__navbar-list-item-icon" src="img/parcelaIcon.png" alt="icono de parcela" />
                            </li>
                        <?php
                        }
                        ?>
                        <?php
                        if (in_array('Piloto', $roles)) {
                        ?>
                            <li class="sidebar__navbar-list-item">
                                Trabajos<button type="submit" value="trabajo" name="opcion"><img class="sidebar__navbar-list-item-icon" src="img/trabajosIcon.png" alt="icono de trabajo" />
                            </li>
                        <?php
                        }
                        ?>
                        <?php
                        if (in_array('Piloto', $roles)) {
                        ?>
                            <li class="sidebar__navbar-list-item">
                                Drones<button type="submit" value="drones" name="opcion"><img class="sidebar__navbar-list-item-icon" src="img/dronIcon.png" alt="icono de dron" />
                            </li>
                        <?php
                        }
                        ?>
                        <?php
                        if (in_array('Administrador', $roles)) {
                        ?>
                            <li class="sidebar__navbar-list-item">
                                Administrar Roles<button type="submit" value="roles" name="opcion"><img class="sidebar__navbar-list-item-icon" src="img/adminIcon.png" alt="icono de roles" />
                            </li>
                        <?php
                        }
                        ?>
                        <li class="sidebar__navbar-list-item">
                            Cerrar Sesion<button type="submit" value="logout" name="opcion"><img class="sidebar__navbar-list-item-icon" src="img/logoutIcon.png" alt="icono de cerrar sesion" />
                        </li>
                    </form>
                </ul>
            </navbar>
            <div class="sidebar__welcome">
                <a href="#" class="sidebar__welcome-link">
                    <img src="img/loginProfile.png" class="sidebar__welcome-profile" /></a>
                <?php
                $nombre = recuperarNombre($_SESSION['idUsuario']);
                print("<h2 class='sidebar__welcome-greet'>Bienvenido, $nombre</h2>");
                ?>
            </div>
        </div>
        <div class="wrapper">
            <?php
            $trabajo = recuperarTrabajo($_GET['idTrabajo']);
            $agricultor = recuperarUsuario($trabajo[2]);
            ?>
            <div class="wrapper__trabajo">
                <h1>Realizar Trabajo</h2>
            <div class="trabajos__data">
                <h2>Datos del Trabajo</h2>
                <div class="datos__trabajo">
                    <div class="tipo__trabajo">
                        Tipo de Trabajo: <?= $trabajo[0] ?>
                    </div>
                    <div class="idAgricultor__trabajo">
                        Agricultor solicito el trabajo: <?= $agricultor[1] . " " . $agricultor[2] ?>
                    </div>
                </div>
            </div>
            <div class="realizar__trabajo">
                <h2>Dron para realizar Trabajo</h2>
                <form action="realizarTrabajo.php">
                    <label for="dron">Dron: </label>
                    <select name="dron">
                        <?php
                        $drones = recuperarDrones($_SESSION['idUsuario']);
                        foreach ($drones as $dron){
                            ?>
                            <option><?=$dron[0]?>
                            <?php
                        }
                        ?>
                    </select>
                    <input type="submit" name="realizarTrabajo" value="Realizar Trabajo">
                </form>
            </div>
            </div>
            <div class="mapContainer">
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <script>
        recuperarParcela(<?= $trabajo[1] ?>)
    </script>
</body>

</html>