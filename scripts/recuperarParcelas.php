<?php
include '../basedatos/sesionBD.php';

$usuarios['parcelas'] = recuperarParcela($_GET['idParcela']);

echo json_encode($usuarios);
?>