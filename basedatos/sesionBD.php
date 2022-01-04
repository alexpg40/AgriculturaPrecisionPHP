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

function registrar($usuario, $apellido, $dni, $contraseña, $email) {
    include 'conexionBD.php';
    $instruccion = "INSERT INTO usuario (idUsuario, nombre, apellido, dni, contrasena, email) VALUES (null, '$usuario', '$apellido', '$dni', '$contraseña', '$email')";
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
    $instruccion = "SELECT * FROM usuario;";
    $consulta = mysqli_query($conexion, $instruccion);
    $nFilas = mysqli_num_rows($consulta);
    $map = array();
    for($i = 0;$i < $nFilas; $i++){
        $resultado = mysqli_fetch_array($consulta);
        $idUsuario = $resultado['idUsuario'];
        $nombre = $resultado['nombre'];
        $apellido = $resultado['apellido'];
        $dni = $resultado['dni'];
        $roles = recuperarRoles($idUsuario);
        $usr = array($idUsuario, $nombre, $apellido, $dni, $roles);
        array_push($map, $usr);
    }
    return $map;
}

function recuperarUsuario($idUsuario){
    include 'conexionBD.php';
    $instruccion = "SELECT * FROM usuario where idUsuario = '$idUsuario'";
    $consulta = mysqli_query($conexion, $instruccion);
    $resultado = mysqli_fetch_array($consulta);
    $idUsuario = $resultado['idUsuario'];
    $nombre = $resultado['nombre'];
    $apellido = $resultado['apellido'];
    $dni = $resultado['dni'];
    $email = $resultado['email'];
    $roles = recuperarRoles($idUsuario);
    $usuario = array($idUsuario,$nombre,$apellido,$dni,$roles, $email);
    return $usuario;
}

function recuperarRolesFalta($idUsuario){
    include 'conexionBD.php';
    $instruccion = "SELECT rol.nombre_rol FROM rol WHERE rol.idRol NOT IN (SELECT usuario_rol.idRol FROM usuario_rol WHERE idUsuario = $idUsuario); ";
    $query = mysqli_query($conexion, $instruccion);
    $nFilas = mysqli_num_rows($query);
    $roles = array();
    for ($i = 0; $i < $nFilas; $i++) {
        $resultado = mysqli_fetch_array($query);
        array_push($roles, $resultado['nombre_rol']);
    }
    return $roles;
}

function borrarUsuario($idUsuario) {
    include 'conexionBD.php';
    $instruccion = "DELETE FROM usuario WHERE idUsuario = '$idUsuario'";
    $query = mysqli_query($conexion, $instruccion);
    mysqli_close($conexion);
}

function darRol($idUsuario, $nombreRol){
    include 'conexionBD.php';
    $instruccion = "INSERT INTO usuario_rol VALUES ($idUsuario, (SELECT rol.idRol FROM rol WHERE rol.nombre_rol = '$nombreRol'))";
    $query = mysqli_query($conexion, $instruccion);
    mysqli_close($conexion);
}

function quitarRol($idUsuario, $nombreRol){
    include 'conexionBD.php';
    $instruccion = "DELETE FROM usuario_rol WHERE usuario_rol.idUsuario = $idUsuario AND usuario_rol.idRol = (SELECT rol.idRol FROM rol WHERE rol.nombre_rol = '$nombreRol')";
    $query = mysqli_query($conexion, $instruccion);
    mysqli_close($conexion);
}

function actualizarUsuario($idUsuario, $nombre, $apellido, $email, $dni){
    include 'conexionBD.php';
    $instruccion = "UPDATE usuario SET ";
    $actualizarUsuario = '';
    if($nombre != ''){
        if($actualizarUsuario == ''){
            $actualizarUsuario.=" nombre = '$nombre'";
        }
    }
    if($apellido != ''){
        if($actualizarUsuario == ''){
            $actualizarUsuario.=" apellido = '$apellido'";
        } else{
            $actualizarUsuario.=", apellido = '$apellido'";
        }
    }
    if($email != ''){
        if($actualizarUsuario == ''){
            $actualizarUsuario.=" email = '$email'";
        } else{
            $actualizarUsuario.=", email = '$email'";
        }
    }
    if($dni != ''){
        if($actualizarUsuario == ''){
            $actualizarUsuario.=" dni = '$dni'";
        } else{
            $actualizarUsuario.=", dni = '$dni'";
        }
    }
    if($actualizarUsuario != ''){
        $instruccion.=$actualizarUsuario.=" WHERE idUsuario = $idUsuario";
        $query = mysqli_query($conexion, $instruccion);
    }
    mysqli_close($conexion);   
}

function recuperarParcelas($idUsuario){
    include 'conexionBD.php';
    $instruccion = "SELECT * FROM parcela WHERE idAgricultor = '$idUsuario'";
    $query = mysqli_query($conexion, $instruccion);
    $parcelas = array();
    $nFilas = mysqli_num_rows($query);
    for ($i=0; $i < $nFilas ; $i++) { 
        $resultado = mysqli_fetch_array($query);
        $idParcela = $resultado['idParcela'];
        $area = $resultado['area'];
        $municipio = $resultado['municipio'];
        $provincia = $resultado['provincia'];
        $puntos = recuperarPuntosParcela($idParcela);
        $parcela = array($idParcela, $area, $municipio, $provincia, $puntos);
        array_push($parcelas, $parcela);
    }
    mysqli_close($conexion);
    return $parcelas;
}

function recuperarPuntosParcela($idParcela){
    include 'conexionBD.php';
    $instruccion = "SELECT * FROM Punto WHERE idParcela = '$idParcela'";
    $query = mysqli_query($conexion, $instruccion);
    $puntos = array();
    $nFilas = mysqli_num_rows($query);
    for ($i=0; $i <$nFilas; $i++) { 
        $resultado = mysqli_fetch_array($query);
        $Long = $resultado['Lon'];
        $Lat = $resultado['Lat'];
        $punto = array($Long, $Lat);
        array_push($puntos, $punto);
    }
    mysqli_close($conexion);
    return $puntos;
}

function recuperarParcela($idParcela){
    include 'conexionBD.php';
    $instruccion = "SELECT * FROM parcela WHERE idParcela = '$idParcela'";
    $query = mysqli_query($conexion, $instruccion);
    $parcelas = array();
    $nFilas = mysqli_num_rows($query);
    for ($i=0; $i < $nFilas ; $i++) { 
        $resultado = mysqli_fetch_array($query);
        $idParcela = $resultado['idParcela'];
        $area = $resultado['area'];
        $municipio = $resultado['municipio'];
        $provincia = $resultado['provincia'];
        $puntos = recuperarPuntosParcela($idParcela);
        $parcela = array($idParcela, $area, $municipio, $provincia, $puntos);
        array_push($parcelas, $parcela);
    }
    mysqli_close($conexion);
    return $parcelas;
}

function recuperarPilotos(){
    include 'conexionBD.php';
    $instruccion = "SELECT * FROM ((usuario INNER JOIN usuario_rol ON usuario.idUsuario = usuario_rol.idUsuario) INNER JOIN rol ON rol.idRol = usuario_rol.idRol) WHERE rol.nombre_rol = 'Piloto';";
    $query = mysqli_query($conexion, $instruccion);
    $nFilas = mysqli_num_rows($query);
    $pilotos = array();
    for ($i=0; $i < $nFilas; $i++) { 
        $resultado = mysqli_fetch_array($query);
        $id = $resultado['idUsuario'];
        $nombre = $resultado['nombre'].' '.$resultado['apellido'];
        array_push($pilotos, array($id, $nombre));
    }
    mysqli_close($conexion);
    return $pilotos;
}

function recuperarTrabajos($idParcela){
    include 'conexionBD.php';
    $instruccion = "SELECT * FROM trabajo, usuario WHERE usuario.idUsuario = trabajo.idPiloto AND trabajo.idParcela = '$idParcela';";
    $query = mysqli_query($conexion,$instruccion);
    $nFilas = mysqli_num_rows($query);
    $trabajos = array();
    for ($i=0; $i < $nFilas; $i++) { 
        $resultado = mysqli_fetch_array($query);
        $tipoTarea = $resultado['tipoTarea'];
        $nombre = $resultado['nombre'];
        $apellido = $resultado['apellido'];
        $fechaFinal = $resultado['fechaFinalizacion'];
        if($fechaFinal == '0000-00-00'){
            $fechaFinal = 'Sin terminar';
        }
        array_push($trabajos, array($tipoTarea, $nombre." ".$apellido, $fechaFinal));
    }
    mysqli_close($conexion);
    return $trabajos;
}

function insertarTrabajo($tipoTarea, $idPiloto, $idAgricultor, $idParcela){
    include 'conexionBD.php';
    $instruccion = "INSERT INTO `trabajo` (`tipoTarea`, `idParcela`, `idPiloto`, `idAgricultor`) VALUES ('$tipoTarea', '$idParcela', '$idPiloto', '$idAgricultor')";
    mysqli_query($conexion, $instruccion);
    mysqli_close($conexion);
}

function eliminarParcela($idParcela){
    include 'conexionBD.php';
    $instruccion = "DELETE FROM parcela WHERE idParcela = '$idParcela'";
    mysqli_query($conexion, $instruccion);
    mysqli_close($conexion);
}

function insertarPuntos($idParcela, $puntos){
    include 'conexionBD.php';
    foreach($puntos as $punto){
        $lon = $punto[0];
        $lat = $punto[1];
        $instruccion = "INSERT INTO punto (idParcela, Lon, Lat) VALUES ('$idParcela', '$lon', '$lat')";
        mysqli_query($conexion,$instruccion);
    }
    mysqli_close($conexion);
}

?>