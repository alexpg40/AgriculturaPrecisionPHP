
const crearParcelas = (parcela) => {
    
}

const recuperarParcelas = () => {
    fetch("scripts/recuperarParcelas.php")
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