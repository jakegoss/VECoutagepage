// set initial map view point
var map = L.map('mapid').setView([44.5, -72.6034], 8);

// add map tile layer and set max zoom
L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href=”http://osm.org/copyright”>OpenStreetMap</a> contributors',
    maxZoom: 11,
}).addTo(map);

var outageValues = serviceTowns;

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

function style(features) {

    let metersOut = outageValues[features.properties.totMeters];

    return {
        fillColor: getColor(metersOut),
        weight: 1,
        opacity: 1,
        color: 'black',
        fillOpacity: 0.3
    };
}
L.geoJson(serviceTowns, { style: style }).addTo(map);


// create hover hightlight and townname popup feature

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

function resetHighlight(e) {
    geojson.resetStyle(e.target);
    info.update();
}

// zoom in on click and show town name and outage data
// function zoomToFeature(e) {
//     map.fitBounds(e.target.getBounds());
// }

// function zoomToPopUp(e) {
//     layer.bindPopup(layer.feature.properties.townMC);
// }





function onEachFeature(feature, layer) {

    //  Onclick gets townname with # of members affected and % of town affected

    var popup = layer.bindPopup(
        ('<h3>' + feature.properties.townMC + '</h3><p># of members affected: ' + feature.properties.totMeters + '<br/>' + feature.properties.metersOut + '% of ' + feature.properties.townMC + ' affected')
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
    let totMeters = '';
    let town = '';

    if (props) {
        metersOut = (outageValues[props.town] ? outageValues[props.town] : 0);
        // percentOut = (outageValues[props.town] ? outageValues[props.town] : 0);
        town = props.townMC;
    }

    let message = 'Hover over a town';
    if (props) {
        message = (metersOut + ' Members affected in ' + town + '<br/>' + metersOut + '% of ' + town + ' affected' + '<br/>'
        );
    }

    this._div.innerHTML = '<h4>VEC Service Territory</h4>' + message;
};

info.addTo(map);

// create legend in bottom and call colors from choropleth params set in getColor function

var legend = L.control({ position: 'bottomleft' });

legend.onAdd = function (map) {

    var div = L.DomUtil.create('div', 'info legend'),
        grades = [1, 20, 40, 60, 80],
        labels = [],
        from, to;

        labels.push('<p>% of Town<br/>Affected</p><br/><i style="background: grey"></i> ' + '0');
    for (var i = 0; i < grades.length; i++) {
        from = grades[i];
        to = grades [i + 1];

        div.innerHTML =
        labels.push(
            '<i style="background:' + getColor(from + 1) + '"></i> ' + from + (to ? '&ndash;' + to : '+' ));
    }
    div.innerHTML = labels.join('<br>');
    return div;
};

legend.addTo(map);

// '% of Towns Affected Scale<br/>'
// //// features diabled

// map.dragging.disable();
// map.touchZoom.disable();
map.doubleClickZoom.disable();
map.scrollWheelZoom.disable();


