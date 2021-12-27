<?php
include '../basedatos/sesionBD.php';

$usuarios['parcelas'] = recuperarParcelas($_GET['idUsuario']);

echo json_encode($usuarios);
?>