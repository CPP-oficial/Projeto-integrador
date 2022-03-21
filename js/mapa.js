var coodernadas = [-5.627303,-37.8084224];
var zoom = 17;
var msg = 'Instituto Federal de Educação, Ciências e Tecnologias do Rio Grande do Norte - campus Apodi.<br> Instutuição, no qual o CPP está sendo desenvolvido.';
var parametros_icone = {
    iconUrl: "../../image/pointer.png"
    , iconSize: [50, 50]
    , iconAnchor: [20, 50]
    , popupAnchor: [0, -50]};
    
var map = L.map('map').setView(coodernadas, zoom);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

var icone = L.icon(parametros_icone);
    
L.marker(coodernadas, {icon: icone})
    .addTo(map)
    .bindPopup(msg);