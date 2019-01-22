// set initial map view point
var map = L.map('mapid').setView([44.5, -72.6034], 8);

// add map tile layer and set max zoom
L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href=”http://osm.org/copyright”>OpenStreetMap</a> contributors',
    maxZoom: 11,
}).addTo(map);

// add Vermont Border lines
// let vtBounds = L.geoJson(vtMap, {
//     color: 'green',
//     weight: '1',
//     zindex: '0',
// }).addTo(map)


// add town polygon
let townBoundaries = L.geoJson(outTowns, {
    color: '#000',
    fillColor: 'grey',
    weight: '0.7',
    zindex: '2',
}).addTo(map)

var metersOut = metersOut

// set color params
function getColor(d) {
    return  d > 500  ? '#FF0000' :
            d > 100  ? '#FFA500' :
            d > 50   ? '#FFFF00' :
            d > 1    ? '#7CFC00' :
            d > 0    ? '#0000FF' :
                     'grey';
}

// define density by # of meters out

// function defineDensity(metersOut) {
//     if (metersOut > 500)  d = 500;
    
//   }
// defineDensity();

// default polygon colors

function style(feature) {
    return {
        fillColor: getColor(feature.properties.choroplethData),
        weight: 1,
        opacity: 1,
        color: 'grey',
        fillOpacity: 0.3
    };
}


// TOWN HIGHLIGHT FEATURE AND TOWNNAME POPUP

function highlightFeature(e) {
    var layer = e.target;
    layer.bindPopup(layer.feature.properties.TOWNNAME);
    layer.setStyle({
        weight: 4,
        color: '#666',
        fillOpacity: 0.7,

    });

    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
        layer.bringToFront();
    }
}

function zoomToFeature(e) {
    map.fitBounds(e.target.getBounds());
}
function resetHighlight(e) {
    geojson.resetStyle(e.target);
}
function onEachFeature(feature, layer) {
    layer.on({
        mouseover: highlightFeature,
        mouseout: resetHighlight,
        click: zoomToFeature
    });
}

geojson = L.geoJson(outTowns, {
    style: style,
    onEachFeature: onEachFeature,
}).addTo(map);

// add info pane

var info = L.control();

info.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
    this.update();
    return this._div;
};

// method that we will use to update the control based on feature properties passed
info.update = function (properties) {
 
    this._div.innerHTML = '<h4>Current number of Outages in</h4>' +  (properties ?
        '<b>' + properties.TOWNNAME + '</b><br />' + properties.metersOut
        : 'Click on a town');
};

info.addTo(map);








// //// features diabled

// map.dragging.disable();
// map.touchZoom.disable();
map.doubleClickZoom.disable();
map.scrollWheelZoom.disable();