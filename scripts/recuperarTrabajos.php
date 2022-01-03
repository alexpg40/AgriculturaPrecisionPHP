<?php
include '../basedatos/sesionBD.php';

$idParcela = $_GET['idParcela'];

$parcelas['trabajos'] = recuperarTrabajos($idParcela);

echo json_encode($parcelas);
?>