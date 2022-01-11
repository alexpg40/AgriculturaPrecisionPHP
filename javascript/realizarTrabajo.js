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
            crearMapa(parcelas.parcelas[0]);
        })
}

const crearMapa = (parcela) => {
    let puntos = parcela[4];
    let divMap = document.getElementById('map');
    let mapContainer = document.getElementsByClassName('mapContainer')[0];
    if (divMap != undefined) {
        divMap.parentNode.removeChild(divMap);
    }
    let mapDiv = document.createElement('div');
    mapDiv.id = "map";
    mapContainer.appendChild(mapDiv);
    let mapa = L.map('map').setView(puntos[0], 17);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(mapa);
    L.polygon(puntos, { color: 'green' }).addTo(mapa);
}