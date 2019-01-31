// set initial map view point
var map = L.map('mapid').setView([44.5, -72.6034], 8);

// add map tile layer and set max zoom
L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href=”http://osm.org/copyright”>OpenStreetMap</a> contributors',
    maxZoom: 11,
}).addTo(map);

// var dataObject

// add town polygon
L.geoJson(serviceTowns, {
    color: '#000',
    fillColor: 'grey',
    weight: '0.7',
    zindex: '2',
}).addTo(map)

// set color params
function getColor(metersOut) {
    return  metersOut > 500  ? '#FF0000' :
            metersOut > 100  ? '#FFA500' :
            metersOut > 50   ? '#FFFF00' :
            metersOut > 1    ? '#7CFC00' :
            metersOut > 0    ? '#0000FF' :
                     'grey';
}

function style(feature) {
    return {
        fillColor: getColor(serviceTowns.metersOut),
        weight: 1,
        opacity: 1,
        color: 'black',
        fillOpacity: 0.3
    };
}
L.geoJson(serviceTowns, {style: style}).addTo(map);

// TOWN HIGHLIGHT FEATURE AND town POPUP
function highlightFeature(e) {
    var layer = e.target;
    highLightPopup();
    info.update(layer.feature.properties);
    layer.setStyle({
        weight: 4,
        color: '#666',
        fillOpacity: 0.7,
    });

    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
        layer.bringToFront();
    }

    function highLightPopup() {
        layer.bindPopup(layer.feature.properties.townMC);
    }
}

function zoomToFeature(e) {
    map.fitBounds(e.target.getBounds());
}
function resetHighlight(e) {
    geojson.resetStyle(e.target);
    info.update();
}
function onEachFeature(feature, layer) {
    layer.on({
        click: zoomToFeature,
        mouseover: highlightFeature,
        mouseout: resetHighlight
    });
}

geojson = L.geoJson(serviceTowns, {
    style: style,
    onEachFeature: onEachFeature,
}).addTo(map);

// Add Info Pane
 
var info = L.control();

info.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
    this.update();
    return this._div;
};

// method that we will use to update the control based on feature properties passed
info.update = function (props) {
    this._div.innerHTML = '<h4>VEC Service Territory</h4>' +  (props ?
        '<b>' + props.metersOut + ' Outages in ' + '<br />' + props.townMC 
        : 'Hover over a town</b>');
};

info.addTo(map);

// Add Legend

var legend = L.control({position: 'bottomright'});

legend.onAdd = function (map) {

    var div = L.DomUtil.create('div', 'info legend'),
        grades = [0, 1, 10, 50, 100, 500],
        labels = [];

    // loop through our numout intervals and generate a label with a colored square for each interval
    for (var i = 0; i < grades.length; i++) {
        div.innerHTML +=
        '<i style="background:' + getColor(grades[i] + 1) + '"></i> ' +
        grades[i] + (grades[i + 1] ? '&ndash;' + grades[i + 1] + '<br>' : '+');
    }

    return div;
};
legend.addTo(map);



// //// features diabled

// map.dragging.disable();
// map.touchZoom.disable();
map.doubleClickZoom.disable();
map.scrollWheelZoom.disable();