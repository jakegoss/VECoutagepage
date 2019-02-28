// set initial map view point
var map = L.map('mapid').setView([44.5, -72.6034], 8);

// add map tile layer and set max zoom
L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href=”http://osm.org/copyright”>OpenStreetMap</a> contributors',
    maxZoom: 11,
}).addTo(map);


// add town polygon
L.geoJson(serviceTowns, {
    color: '#000',
    fillColor: 'grey',
    weight: '0.7',
    zindex: '2',
}).addTo(map)

// set choropleth params from metersOut in outageValues
function getColor(metersOut) {
    return metersOut > 80 ? '#FF0000' :
           metersOut > 60 ? '#FFA500' :
           metersOut > 40 ? '#FFFF00' :
           metersOut > 20 ? '#7CFC00' :
           metersOut > 0 ? '#0000FF' :
                        'grey';
}

// call outage data from php generated object "outageValues" and apply to polygon

function style(feature) {

    let metersOut = outageValues[feature.properties.town];

    return {
        fillColor: getColor(metersOut),
        weight: 1,
        opacity: 1,
        color: 'black',
        fillOpacity: 0.3
    };
}
L.geoJson(serviceTowns, { style: style }).addTo(map);


// create hover hightlight and add data to infopane

function highlightFeature(e) {

    var layer = e.target;

    info.update(layer.feature.properties);
    layer.setStyle({
        weight: 4,
        color: '#666',
        fillOpacity: 0.7,
    });

    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
        layer.bringToFront();
    }
}

// Clear previous hover info on mouseout
function resetHighlight(e) {
    geojson.resetStyle(e.target);
    info.update();
}

function onEachFeature(feature, layer) {

    //  Onclick gets townname with # of members affected and % of town affected
    var popup = layer.bindPopup(




        // ('<h3>' + feature.properties.townMC + '</h3><p># of members affected: ' + feature.properties.totMeters + '<br/>' + feature.properties.metersOut + '% of ' + feature.properties.townMC + ' affected')
    );
    
// Set click params and generate popup for click
    layer.on({
        click: popup,
        mouseover: highlightFeature,
        mouseout: resetHighlight
    });
}




geojson = L.geoJson(serviceTowns, {
    style: style,
    onEachFeature: onEachFeature,
}).addTo(map);

// Add Info pane to map div

var info = L.control();

info.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
    this.update();
    return this._div;
};

// call town data from outageValues and display in infopane
info.update = function (props) {

    let metersOut = '0';
    let town = '';

    if (props) {
        metersOut = (outageValues[props.town] ? outageValues[props.town] : 0);
        town = props.townMC;
    }

    let message = 'Hover over a town';
    if (props) {
        message = metersOut + '% of Members affected in ' + town + '</br>';
    }

    this._div.innerHTML = '<h4>VEC Service Territory</h4>' + message;
};

info.addTo(map);

// create legend in bottom right and call colors from choropleth params set in getColor function

var legend = L.control({ position: 'bottomright' });

legend.onAdd = function (map) {

    var div = L.DomUtil.create('div', 'info legend'),
        grades = [0, 20, 40, 60, 80],
        labels = [];

    // loop through our metersOut intervals and generate a label with a colored square for each interval
    // this is currently clunky and showing undersirable values

    labels.push('<i style="background: grey"></i> ' + 'undefined');
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