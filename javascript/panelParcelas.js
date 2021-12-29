
const recuperarParcela = (idParcela) => {
    fetch("scripts/recuperarParcelas.php?idParcela=" + idParcela)
        .then((response) => {
            if (response.ok) {
                return response.json();
            } else {
                return new Error('Error en la petición al recuperar las parcelas');
            }
        })
        .then((parcelas) => {
            console.log(parcelas.parcelas);
            let mapa = crearAreaParcela(parcelas.parcelas[0][4]);
        })
}

const crearAreaParcela = (puntos) => {
    let divMap = document.getElementById('map');
    let mapContainer = document.getElementsByClassName('parcela__item')[0];
    if(divMap != undefined){
        divMap.parentNode.removeChild(divMap);
    }
    let mapDiv = document.createElement('div');
    mapDiv.id = "map";
    console.log(mapDiv);
    mapContainer.appendChild(mapDiv);
    let mapa = L.map('map').setView(puntos[0], 17);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(mapa);
    let poligonoParcela = L.polygon(puntos, { color: 'green' }).addTo(mapa);
    return mapa;
}

const cambiarMapa = (mapa, puntos) =>{

}