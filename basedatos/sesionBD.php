<?php

function iniciarSesion($usuario, $contraseña){
    include 'conexionBD.php';
    $instruccion = "SELECT nombre FROM usuario WHERE nombre = '$usuario' AND contrasena = '$contraseña'";
    $consulta = mysqli_query($conexion, $instruccion)
             or die('No se ha podido iniciar sesion!');
     $nFilas = mysqli_num_rows($consulta);
     if($nFilas > 0){
         return true;
     } else{
         return false;
     }
     mysqli_close($conexion);
}

function registrar($usuario, $apellido, $dni, $contraseña){
    include 'conexionBD.php';
    $instruccion = "INSERT INTO usuario (idUsuario, nombre, apellido, dni, contrasena) VALUES (null, '$usuario', '$apellido', '$dni', '$contraseña')";
    mysqli_query($conexion, $instruccion)
            or die('No se ha podido registrar el usuario!');
    mysqli_close($conexion);
}

?>