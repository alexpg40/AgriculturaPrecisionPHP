window.onload = () => {
    recuperarUsuarios();
}

const crearUsuarios = (todosUsuarios) => {
    let adminUser = document.getElementsByClassName('wrapper__admin-users')[0];
    todosUsuarios.forEach((arrayUsuario) => {
        let divUsuario = document.createElement('div');
        divUsuario.className = 'wrapper__admin-users-item';
        let iconoUsuario = document.createElement('img');
        iconoUsuario.src = 'img/loginProfile.png';
        let divImagen = document.createElement('div');
        divImagen.className = 'wrapper__admin-users-item-icon';
        divImagen.appendChild(iconoUsuario);
        divUsuario.appendChild(divImagen);
        let usuarioID = arrayUsuario[0];
        let divId = document.createElement('div');
        divId.className = 'wrapper__admin-users-item-idUsuario';
        divId.innerText = usuarioID;
        divUsuario.appendChild(divId)
        let usuarioNombre = arrayUsuario[1];
        let divNombre = document.createElement('div');
        divNombre.className="wrapper__admin-users-item-nombre";
        divNombre.innerText = usuarioNombre;
        divUsuario.appendChild(divNombre);
        let usuarioApellido = arrayUsuario[2];
        let divApellido = document.createElement('div');
        divApellido.className="wrapper__admin-users-item-apellido";
        divApellido.innerText = usuarioApellido;
        divUsuario.appendChild(divApellido);
        let usuarioDNI = arrayUsuario[3];
        let divDNI = document.createElement('div');
        divDNI.className = "wrapper__admin-users-item-dni";
        divDNI.innerText = usuarioDNI;
        divUsuario.appendChild(divDNI);
        let arrayRoles = arrayUsuario[4];
        let divRoles = document.createElement('div');
        divRoles.className = "wrapper__admin-users-item-roles";
        if(arrayRoles.length > 0){
            let selectRoles = document.createElement('select');
            arrayRoles.forEach((rol) => {
                let option = document.createElement('option');
                option.innerText = `${rol}`;
                selectRoles.appendChild(option);
            })
            divRoles.appendChild(selectRoles);
        } else {
            divRoles.innerText = 'No tiene ningun rol asignado';
        }
        let divSelect = document.createElement('div');
        let boton = document.createElement('button');
        boton.innerText = 'Editar';
        boton.name = 'idUsuario';
        boton.value = usuarioID;
        divSelect.className = "wrapper__admin-users-item-select";
        divSelect.appendChild(boton);
        divUsuario.appendChild(divSelect);
        divUsuario.appendChild(divRoles);
        adminUser.appendChild(divUsuario);
    })
}

function recuperarUsuarios(){
    fetch('scripts/recuperarUsuario.php')
    .then((response) => {
        if(response.ok){
            return response.json();
        } else{
            return new Error('Fallo al intentar recuperar los usuarios');
        }
    })
    .then((todosUsuarios) => {
        todosUsuarios = todosUsuarios.usuarios[0];
        todosUsuarios = todosUsuarios.filter((usuario) => !usuario[4].includes('Administrador'))
        crearUsuarios(todosUsuarios);
    })
    .catch((err) => {console.error(err);});
}