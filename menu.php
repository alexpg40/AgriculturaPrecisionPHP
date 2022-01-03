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
    <script src="javascript/panelParcelas.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
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
            if (!isset($_REQUEST['opcion'])) {
                if (in_array('Administrador', $roles)) {
                    $usuariosRoles = recuperarTodosUsuarios();
            ?>
                    <div class="wrapper__admin">
                        <form action="editarUsuario.php">
                            <h1 class="wrapper__title">Mostrar usuarios</h1>
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

                            </div>
                        </form>
                        <script src="javascript/adminUser.js"></script>
                    </div>
                <?php
                } else if (in_array('Agricultor', $roles)) {
                ?>
                    <div class="wrapper__parcelas">
                        <h1 class="wrapper__title">Tus parcelas</h1>
                        <div class="wrapper__parcelas-panel">

                        </div>
                    </div>
                <?php
                }
            } else if ($_REQUEST['opcion'] == 'roles') {
                if (in_array('Administrador', $roles)) {
                ?>
                    <div class="wrapper__admin">
                        <form action="editarUsuario.php">
                            <h1 class="wrapper__title">Mostrar usuarios</h1>
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

                            </div>
                        </form>
                        <script src="javascript/adminUser.js"></script>
                    </div>
                <?php
                } else {
                    print('Usted no tiene permisos para entrar aqui!');
                }
            } else if ($_REQUEST['opcion'] == 'parcela') {
                ?>
                <div class="wrapper__parcelas">
                    <h1 class="wrapper__title">Tus parcelas</h1>
                    <div class="wrapper__buttons">
                        <button id="crear_parcela" value="crear_parcela">Crear Parcela</button>
                        <button id="eliminar_parcela" value="eliminar_parcela">Eliminar Parcela</button>
                    </div>
                    <div class="parcelas_table">
                        <div class="parcela__table__header">
                            <div class="parcela__header__id">
                                Id
                            </div>
                            <div class="parcela__header__area">
                                Area
                            </div>
                            <div class="parcela__header__municipio">
                                Municipio
                            </div>
                            <div class="parcela__header__provincia">
                                Provincia
                            </div>
                            <div class="parcela__header__seleccionar">
                                Seleccionar
                            </div>
                        </div>
                        <div class="parcela__table__items">
                            <?php
                            $parcelas = recuperarParcelas($_SESSION['idUsuario']);
                            foreach ($parcelas as $parcela) {
                            ?>
                                <div class="parcela__table__item">
                                    <div class="parcela__id">
                                        <?= $parcela[0] ?>
                                    </div>
                                    <div class="parcela__area">
                                        <?= $parcela[1] ?>
                                    </div>
                                    <div class="parcela__municipio">
                                        <?= $parcela[2] ?>
                                    </div>
                                    <div class="parcela__provincia">
                                        <?= $parcela[3] ?>
                                    </div>
                                    <div class="parcela__seleccionar">
                                        <input type="radio" name="seleccionar" onclick="recuperarParcela(<?= (int)$parcela[0] ?>)" value="<?= $parcela[0] ?>">
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="wrapper__parcelas-panel">
                        <div class="parcela__item">
                            <div class="parcela__data">
                            <h2>Crear Trabajo Rapido</h2>
                            <hr>
                                <div class="parcela__form__data">
                                    <form class="parcela__data__form" action="get">
                                        <h2>Seleccionar Trabajo</h2>
                                        <select name="tipoTrabajo">
                                            <option>Abonar</option>
                                            <option>Fumigar</option>
                                        </select>
                                        <h2>Seleccionar Piloto</h2>
                                        <select name="piloto">
                                            <?php
                                            $pilotos = recuperarPilotos();
                                            foreach ($pilotos as $piloto) {
                                            ?>
                                                <option value="<?= $piloto[0] ?>"><?= $piloto[1] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <button type="submit" name="programarParcela" value="Programar Trabajo">Programar Trabajo</button>
                                    </form>
                                </div>
                                <h2>Ultimos Trabajos en la Parcela</h2>
                                <hr>
                                <div class="parcela__trabajos__table">
                                    <div class="parcela__trabajos__table__header">
                                        <div class="parcela__header__id">
                                            Tipo Trabajo
                                        </div>
                                        <div class="parcela__header__area">
                                            Piloto
                                        </div>
                                        <div class="parcela__header__municipio">
                                            Fecha de Finalizacion
                                        </div>
                                    </div>
                                    <div class="parcela__trabajos__items">
                                    
                                </div>
                                </div>
                            </div>
                            <div id="map">

                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
</body>

</html>