document.onload = () => {
    crearUsuarios();
}

const crearUsuarios = () => {
    let adminUser = document.getElementsByClassName('wrapper__admin-users');
    let todosUsuarios = recuperarUsuarios();
}

const recuperarUsuarios = () => {
    fetch('localhost/AgriculturaPrecisionPHP/scripts/recuperarUsuario.php')
    .then((response) => {
        if(response.ok){
            return response.json();
        } else{
            return new Error('Fallo al intentar recuperar los usuarios');
        }
    })
    .then((jsonUsuarios) => {
        console.log(jsonUsuarios);
    })
    .catch((err) => {console.error(err);});
}