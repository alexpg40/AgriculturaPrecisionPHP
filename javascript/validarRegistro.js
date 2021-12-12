document.onload = () => {

    let botonRegistrar = document.getElementsByName('registrar');
    botonRegistrar.addEventListener('click', () => {
        let nombre = document.getElementsByName('nombre').value;
        let contrasena = document.getElementsByName('contrasena').value;
        let dni = document.getElementsByName('dni').value;
        let apellido = document.getElementsByName('apellido').value;
        let validarNombre = validarNombre(nombre);
        let validarApellido = validarApellido(apellido);
        let validarDNI = validarDNI(dni);
        let validarContrasena = validarContrasena(contrasena);
    })

}

const enviarValidacion = (nombre, apellido, contrasena, dni) => {
    fetch("../registro.php?validarNombre="+nombre)
}

const validarNombre = (nombre) => {
    let numeroRegex = /[0-9]/;
    if (nombre.length < 3 || !nombre.test(numeroRegex)) {
        return false;
    }
    return true;
}

const validarApellido = (apellido) => {
    let numeroRegex = /[0-9]/;
    if (apellido.length < 3 || !apellido.test(numeroRegex)) {
        return false;
    }
    return true;
}

const validarDNI = (dni) => {
    let dniRegex = /[0-9]{8}[aA-zZ]/
    if (!dni.test(dniRegex)) {
        return false;
    }
    return true;
}

const validarContrasena = (contrasena) => {
    let contrasenaRegex = /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/;
    if (!contrasenaRegex.test(contrasena)) {
        return false;
    }
    return true;
}