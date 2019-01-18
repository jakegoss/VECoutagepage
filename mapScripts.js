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
let countyBoundaries = L.geoJson(serviceTowns, {
    color: '#000',
    fillColor: 'grey',
    weight: '0.7',
    zindex: '2',
}).addTo(map)

// set color params
function getColor(d) {
    return  d > 500  ? '#FF0000' :
            d > 100  ? '#FFA500' :
            d > 50   ? '#FFFF00' :
            d > 1    ? '#7CFC00' :
            d > 0    ? '#0000FF' :
                     'grey';
}

function style(feature) {
    return {
        fillColor: getColor(feature.properties.density),
        weight: 1,
        opacity: 1,
        color: 'black',
        fillOpacity: 0.3
    };
}
L.geoJson(serviceTowns, {style: style}).addTo(map);


function highlightFeature(e) {
    var layer = e.target;

    layer.setStyle({
        weight: 5,
        color: '#666',
        dashArray: '',
        fillOpacity: 0.7
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

geojson = L.geoJson(serviceTowns, {
    style: style,
    onEachFeature: onEachFeature
}).addTo(map);

var info = L.control();

info.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
    this.update();
    return this._div;
};

// method that we will use to update the control based on feature properties passed
info.update = function (props) {
    this._div.innerHTML = '<h4>Current number of Outages in</h4>' +  (props ?
        '<b>' + props.town + '</b><br />' + props.density
        : 'Hover over a town');
};

info.addTo(map);

