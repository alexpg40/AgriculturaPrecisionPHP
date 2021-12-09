<?php

$conexion = mysqli_connect('localhost', 'root', '', 'agriculturadeprecision')
        or die('Fallo en la conexión con la base de datos!');

return $conexion;

?>