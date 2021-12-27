
const crearParcelas = (parcela) => {
    let parcelasContainer = document.getElementsByClassName('parcela__items')
    let divParcela = document.createElement('div');
    let datosParcela = document.createElement('div');
}

const recuperarParcelas = (idUsuario) => {
    fetch("scripts/recuperarParcelas.php?idUsuario="+idUsuario)
    .then((response) => {
        if(response.ok){
            return response.json();
        } else{
            return new Error('Error en la petición al recuperar las parcelas');
        }
    })
    .then((parcelas) => {
        console.log(parcelas);
        crearParcelas(parcelas);
    })
}