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
    let lineaAbajo = [caja._latlngs[0][3], caja._latlngs[0][0]];
    dividirRecta(mapa, lineaArriba)
    dividirRecta(mapa, lineaAbajo);
    let polylinePath = ordenarPolypath(lineaArriba, lineaAbajo);
    let polyline = L.polyline(polylinePath, {color: 'black'});
    let coordenadas1 = polyline._latlngs.map(({lat, lng}) => [lat, lng]);
    let coordenadas2 = mapaParcela._latlngs.map(({lat, lng}) => [lat, lng]);
    var intersects = turf.lineIntersect(polyline.toGeoJSON(), mapaParcela.toGeoJSON());
    let coordenadasGeoJSON = intersects.features.map(({geometry}) => geometry.coordinates);
    let coordenadasFinales = coordenadasGeoJSON.map((coordenada) => L.GeoJSON.coordsToLatLng(coordenada));
    console.log(coordenadasFinales);
    coordenadasFinales = ordenarPolypathInterior(coordenadasFinales);
    console.log(coordenadasFinales);
    L.polyline(coordenadasFinales, {color: 'black'}).addTo(mapa);
}

const crearPuntoMedio = (mapa, latlng1, latlng2) => {
    const p1 = mapa.project(latlng1);
    const p2 = mapa.project(latlng2);
    return mapa.unproject(p1._add(p2)._divideBy(2));
}

const dividirRecta = (mapa, puntos) => {
    for (let j = 0; j < 5; j++) {
        let puntosNuevos = [];
        for (let i = 1; i < puntos.length; i++) {
            puntosNuevos.push(crearPuntoMedio(mapa, puntos[i-1], puntos[i]));
        }
        puntos.push(...puntosNuevos);
        puntos.sort((a, b) => a.lng - b.lng);
    }
}

const ordenarPolypath = (lineaArriba, lineaAbajo) =>{
    let polyPath = [];
    polyPath.push(lineaAbajo[0]);
    for (let i = 1; i < lineaArriba.length; i+=2) {
        polyPath.push(lineaArriba[i - 1]);
        polyPath.push(lineaArriba[i]);
        polyPath.push(lineaAbajo[i]);
        polyPath.push(lineaAbajo[i + 1]);
    }
    polyPath.push(lineaArriba[lineaArriba.length-1]);
    return polyPath;
}

const ordenarPolypathInterior = (coordenadas) => {
    let ret = [];
    ret.push(coordenadas[0]);
    for (let i = 1; i < coordenadas.length - 1; i+=2) {
        if(ret[ret.length - 1].distanceTo(coordenadas[i]) < ret[ret.length - 1].distanceTo(coordenadas[i+1])){
            ret.push(coordenadas[i]);
            ret.push(coordenadas[i+1]);
        } else{
            ret.push(coordenadas[i+1]);
            ret.push(coordenadas[i]);
        }
    }
    ret.push(coordenadas[coordenadas.length - 1]);
    return ret;
}