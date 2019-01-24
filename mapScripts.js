// set initial map view point
var map = L.map('mapid').setView([44.5, -72.6034], 8);

// add map tile layer and set max zoom
L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href=”http://osm.org/copyright”>OpenStreetMap</a> contributors',
    maxZoom: 11,
}).addTo(map);


// add town polygon
L.geoJson(outTowns, {
    color: '#000',
    fillColor: 'grey',
    weight: '0.7',
    zindex: '2',
    
}).addTo(map);




// set color params
function getColor(d) {
    return  d > 500  ? '#FF0000' :
    d > 100  ? '#FFA500' :
    d > 50   ? '#FFFF00' :
    d > 1    ? '#7CFC00' :
    d > 0    ? '#0000FF' :
    'grey';
}


// default polygon colors

function style(feature) {
    return {
        fillColor: getColor(feature.properties.density),
        weight: 1,
        opacity: 1,
        color: 'black',
        fillOpacity: 0.3
    };
}
L.geoJson(outTowns, {style: style}).addTo(map);


// TOWN HIGHLIGHT FEATURE AND TOWNNAME POPUP

function highlightFeature(e) {
    var layer = e.target;
    highLightPopup();
    layer.setStyle({
        weight: 4,
        color: '#666',
        fillOpacity: 0.7,
        
    });

    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
        layer.bringToFront();
    }

    function highLightPopup() {
        layer.bindPopup(layer.feature.properties.TOWNNAME);
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
        click: zoomToFeature,
        mouseover: highlightFeature,
        mouseout: resetHighlight
    });
}

geojson = L.geoJson(outTowns, {
    style: style,
    onEachFeature: onEachFeature,
}).addTo(map);





// //// features diabled

// map.dragging.disable();
// map.touchZoom.disable();
map.doubleClickZoom.disable();
map.scrollWheelZoom.disable();