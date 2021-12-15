<?php

function iniciarSesion($usuario, $contraseña) {
    include 'conexionBD.php';
    $instruccion = "SELECT idUsuario FROM usuario WHERE nombre = '$usuario' AND contrasena = '$contraseña'";
    $consulta = mysqli_query($conexion, $instruccion)
            or die('No se ha podido iniciar sesion!');
    $nFilas = mysqli_num_rows($consulta);
    if ($nFilas > 0) {
        $resultado = mysqli_fetch_array($consulta);
        $idUsuario = $resultado['idUsuario'];
    } else {
        $idUsuario = 0;
    }
    mysqli_close($conexion);
    return $idUsuario;
}

function registrar($usuario, $apellido, $dni, $contraseña) {
    include 'conexionBD.php';
    $instruccion = "INSERT INTO usuario (idUsuario, nombre, apellido, dni, contrasena) VALUES (null, '$usuario', '$apellido', '$dni', '$contraseña')";
    mysqli_query($conexion, $instruccion)
            or die('No se ha podido registrar el usuario!');
    mysqli_close($conexion);
}

function buscarDNI($dni) {
    include 'conexionBD.php';
    $instruccion = "SELECT idUsuario FROM usuario WHERE dni = '$dni'";
    $query = mysqli_query($conexion, $instruccion)
            or die('No se ha podido registrar el usuario!');
    if (mysqli_num_rows($query) != 0) {
        mysqli_close($conexion);
        return true;
    }
    return false;
}

function recuperarRoles($idUsuario) {
    include 'conexionBD.php';
    $instruccion = "SELECT rol.nombre_rol FROM ((rol INNER JOIN usuario_rol ON rol.idRol = usuario_rol.idRol) "
            . "INNER JOIN usuario ON usuario.idUsuario = usuario_rol.idUsuario) WHERE usuario.idUsuario = $idUsuario;";
    $query = mysqli_query($conexion, $instruccion);
    $nFilas = mysqli_num_rows($query);
    $roles = array();
    for ($i = 0; $i < $nFilas; $i++) {
        $resultado = mysqli_fetch_array($query);
        array_push($roles, $resultado['nombre_rol']);
    }
    return $roles;
}

function recuperarNombre($idUsuario) {
    include 'conexionBD.php';
    $instruccion = "SELECT nombre FROM usuario WHERE idUsuario = $idUsuario";
    $query = mysqli_query($conexion, $instruccion);
    $nFilas = mysqli_num_rows($query);
    $resultado = mysqli_fetch_array($query);
    $nombre = $resultado['nombre'];
    return $nombre;
}

function recuperarTodosUsuarios(){
    include 'conexionBD.php';
    $instruccion = "SELECT usuario.idUsuario FROM usuario;";
    $consulta = mysqli_query($conexion, $instruccion);
    $nFilas = mysqli_num_rows($consulta);
    $map = array();
    for($i = 0;$i < $nFilas; $i++){
        $resultado = mysqli_fetch_array($consulta);
        $idUsuario = $resultado['idUsuario'];
        $nombre = $resultado['nombre'];
        print($nombre);
        $roles = recuperarRoles($idUsuario);
        $map[$nombre] = $roles;
    }
    return map;
}

?>