
<?php

    function validarNombre($nombre){
        if(strlen($nombre)<3){
            return false;
        }
        if(strlen($contrasena)>16){
            return false;
        }
        return true;
    }
    
    function validarApellido($apellido){
        if(strlen($apellido)<3){
            return false;
        }
        if(strlen($contrasena)>16){
            return false;
        }
        return true;
    }
    
    function validarContraseña($contrasena){
        if(strlen($contrasena)<8){
            return false;
        }
        if(strlen($contrasena)>16){
            return false;
        }
        if(!preg_match('`[A-Z]`', $contrasena)){
            return false;
        }
        if(!preg_match('`[a-z]`', $contrasena)){
            return false;
        }
        if(!preg_match('`[0-9]`', $contrasena)){
            return false;
        }
        return true;
    }
    
    function validarDNI($dni){
        include '../basedatos/sesionBD.php';
        if(strlen($dni) != 9){
            return false;
        }
        if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros%23, 1) == $letra && strlen($letra) == 1 && strlen ($numeros) == 8 ){
            return false;
        }
        if(buscarDNI($dni)){
            return false;
        }
        
        return true;
    }
    
?>