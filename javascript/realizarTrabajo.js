/*Recupero la parcela haciendo un fetch a un script php*/
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

/*Creo el mapa con la parcela y la ruta del dron */
const crearMapa = (parcela) => {
    //Recupero los puntos de la parcela
    let puntos = parcela[4];
    
    //Elimino el mapa si existe
    let divMap = document.getElementById('map');
    let mapContainer = document.getElementsByClassName('mapContainer')[0];
    if (divMap != undefined) {
        divMap.parentNode.removeChild(divMap);
    }

    //Creo el div donde se creara el mapa
    let mapDiv = document.createElement('div');
    mapDiv.id = "map";
    mapContainer.appendChild(mapDiv);

    //Creo el mapa
    let mapa = L.map('map').setView(puntos[0], 17);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(mapa);

    //Dibujo la parcela en el mapa
    let mapaParcela = L.polygon(puntos, { color: 'green' }).addTo(mapa);

    //Dibujo la caja que contiene a la parcela
    let caja = L.rectangle(mapaParcela.getBounds(), { color: 'red' }).addTo(mapa);

    //Consigo las lineas de arriba y de abajo del cuadrado
    let lineaArriba = [caja._latlngs[0][1], caja._latlngs[0][2]];
    let lineaAbajo = [caja._latlngs[0][3], caja._latlngs[0][0]];

    //Divido esas lineas entre varios puntos por donde pasara el polyline
    dividirRecta(mapa, lineaArriba);
    dividirRecta(mapa, lineaAbajo);

    //Polyline de la ruta en el cuadrado 
    let polylinePath = ordenarPolypath(lineaArriba, lineaAbajo);
    let polyline = L.polyline(polylinePath, {color: 'white'});

    //Consigo los puntos de interseccion de la parcela con el polyline del cuadrado
    var intersects = turf.lineIntersect(polyline.toGeoJSON(), mapaParcela.toGeoJSON());

    //Consigo las coordenadas del objeto de la interseccion
    let coordenadasGeoJSON = intersects.features.map(({geometry}) => geometry.coordinates);

    //Convierto las coordenadas en un formato para usarlos en Leaflet
    let coordenadasFinales = coordenadasGeoJSON.map((coordenada) => L.GeoJSON.coordsToLatLng(coordenada));

    //Ordeno las coordenadas para dibujar el polyline de la parcela

    coordenadasFinales = quitarPuntosMaliciosos(coordenadasFinales);

    coordenadasFinales = ordenarPolypathInterior(coordenadasFinales);

    console.log(coordenadasFinales);

    coordenadasFinales.sort((a, b) => a.lng < b.lng)

    //Dibujo el polyline de la parcela en el mapa
    L.polyline(coordenadasFinales, {color: 'black'}).addTo(mapa);
}

//Consigo el punto medio de una recta
const crearPuntoMedio = (mapa, latlng1, latlng2) => {
    const p1 = mapa.project(latlng1);
    const p2 = mapa.project(latlng2);
    return mapa.unproject(p1._add(p2)._divideBy(2));
}

//Divido los puntos de una recta varias veces
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

//Ordena los puntos de ambas lineas para crear el polyline 
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

//Ordena los puntos para crear el polypath interior
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

const quitarPuntosMaliciosos = (coordenadas) => {
    let ret = [];
    ret.push(coordenadas[0]);
    for (let i = 1; i < coordenadas.length -1; i+=2) {
        const coord = coordenadas[i];
        let coordsIguales = coordenadas.filter(({lng})=>lng === coord.lng);
        if(coordsIguales.length >= 2) {
            if(!ret.includes(coordsIguales[0])){
                ret.push(coordsIguales[0]);
            }
            if(!ret.includes(coordsIguales[1])){
                ret.push(coordsIguales[1]);
            }
        }
    }
    return ret;
}