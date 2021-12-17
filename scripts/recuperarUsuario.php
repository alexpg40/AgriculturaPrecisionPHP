<?php
include '../basedatos/sesionBD.php';

$usuarios['usuarios'][] = recuperarTodosUsuarios();

echo json_encode($usuarios);
?>