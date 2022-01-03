window.onload = () => {
    let primerRadioButton = document.getElementsByName('seleccionar')[0];
    primerRadioButton.setAttribute('checked', '');
    recuperarParcela(primerRadioButton.value);
    recuperarTrabajos(primerRadioButton.value);
}



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
            crearAreaParcela(parcelas.parcelas[0]);
            recuperarTrabajos(parcelas.parcelas[0]);
        })
}

const crearAreaParcela = (parcela) => {
    let puntos = parcela[4];
    let divMap = document.getElementById('map');
    let mapContainer = document.getElementsByClassName('parcela__item')[0];
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
    let submitTrabajo = document.getElementsByName('programarParcela')[0];
    submitTrabajo.value = parcela[0];
}

const recuperarTrabajos = (idParcela) => {
    fetch("scripts/recuperarTrabajos.php?idParcela=" + idParcela)
        .then((response) => {
            if (response.ok) {
                return response.json();
            } else {
                return new Error('No se pudo obtener los datos del servidor!');
            }
        })
        .then((trabajos) => {
            crearTablaTrabajos(trabajos);
        })
}

const crearTablaTrabajos = (objeto) => {
    let trabajos = objeto.trabajos;
    let trabajosContainer = document.getElementsByClassName('parcela__trabajos__items')[0];
    while(trabajosContainer.hasChildNodes()){
        trabajosContainer.removeChild(trabajosContainer.childNodes[0]);
    }
    console.log(trabajosContainer);
    trabajos.forEach(trabajo => {
        let trabajoItem = document.createElement('div');
        trabajoItem.className = "parcela__trabajos__item";
        let divTipo = document.createElement('div');
        divTipo.innerText = trabajo[0];
        trabajoItem.appendChild(divTipo);
        let divPiloto = document.createElement('div');
        divPiloto.innerText = trabajo[1];
        trabajoItem.appendChild(divPiloto);
        let divFecha = document.createElement('div');
        divFecha.innerText = trabajo[2];
        trabajoItem.appendChild(divFecha);
        trabajosContainer.appendChild(trabajoItem);
    });
}