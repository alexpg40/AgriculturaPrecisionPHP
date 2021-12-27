
const crearParcelas = (parcela) => {
    let arrayParcelas = parcela.parcelas;
    crearAreaParcela(arrayParcelas[0][4]);
    let parcelasContainer = document.getElementsByClassName('parcela__item')
}

const recuperarParcelas = (idUsuario) => {
    fetch("scripts/recuperarParcelas.php?idUsuario=" + idUsuario)
        .then((response) => {
            if (response.ok) {
                return response.json();
            } else {
                return new Error('Error en la petición al recuperar las parcelas');
            }
        })
        .then((parcelas) => {
            crearParcelas(parcelas);
        })
}

const crearAreaParcela = (puntos) => {
    let mapa = L.map('map').setView(puntos[0], 17);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(mapa);
    let poligonoParcela = L.polygon(puntos, { color: 'green' }).addTo(mapa);
}