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
    let mapaParcela = L.polygon(puntos, { color: 'green' }).addTo(mapa);
    let caja = L.rectangle(mapaParcela.getBounds(), { color: 'red' }).addTo(mapa);
    let lineaArriba = [caja._latlngs[0][1], caja._latlngs[0][2]];
    dividirRecta(mapa, lineaArriba)
    lineaArriba.forEach(punto => { L.marker(punto).addTo(mapa); });
}

const crearPuntoMedio = (mapa, latlng1, latlng2) => {
    const p1 = mapa.project(latlng1);
    const p2 = mapa.project(latlng2);
    return mapa.unproject(p1._add(p2)._divideBy(2));
}

const dividirRecta = (mapa, puntos) => {
    for (let j = 0; j < 3; j++) {
        let puntosNuevos = [];
        for (let i = 1; i < puntos.length; i++) {
            puntosNuevos.push(crearPuntoMedio(mapa, puntos[i-1], puntos[i]));
        }
        puntos.push(...puntosNuevos);
        puntos.sort((a, b) => a.lng - b.lng);
    }
}