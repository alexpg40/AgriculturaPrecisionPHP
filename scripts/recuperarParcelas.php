<?php
include '../basedatos/sesionBD.php';

$usuarios['usuarios'][] = recuperarParcelas($_GET['idUsuario']);

echo json_encode($usuarios);
?>