
var map = L.map('mapid').setView([43.9, -72.6034], 7);

var polyStyle = {
    color: '#000',
    fillColor: 'grey',
    weight: '0.7',
};


L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href=”http://osm.org/copyright”>OpenStreetMap</a> contributors'
}).addTo(map);


L.geoJson(serviceTowns, polyStyle).addTo(map);


