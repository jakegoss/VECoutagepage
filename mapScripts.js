// set initial map view point
var map = L.map('mapid').setView([44.5, -72.6034], 8);

// add map tile layer and set max zoom
L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href=”http://osm.org/copyright”>OpenStreetMap</a> contributors',
    maxZoom: 11,
}).addTo(map);

// add town polygon
let countyBoundaries = L.geoJson(serviceTowns, {
    color: '#000',
    fillColor: 'grey',
    weight: '0.7',
}).addTo(map)

// set color params
function getColor(d) {
    return  d > 500  ? '#FF0000' :
            d > 100  ? '#FFA500' :
            d > 50   ? '#FFFF00' :
            d > 1    ? '#7CFC00' :
            d > 0    ? '#0000FF' :
                     '#000';
}
L.geoJson(serviceTowns, {style: d}).addTo(map);

// function style(feature) {
//     return {
//         fillColor: getColor(feature.properties.density),
//         weight: 1,
//         opacity: 1,
//         color: 'black',
//         fillOpacity: 0.3
//     };
// }

