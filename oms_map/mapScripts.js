// set initial map view point
const map = L.map('mapid').setView([44.5, -72.6034], 8);

// add map tile layer and set max zoom
L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href=”http://osm.org/copyright”>OpenStreetMap</a> contributors',
    maxZoom: 11,
}).addTo(map);

// Global Variables ////////
// let metersOut = '0';
// let percentOut = '';
// let town = '';

// add town polygon
L.geoJson(serviceTowns, {
    color: '#000',
    fillColor: 'grey',
    weight: '0.7',
    zindex: '2',
}).addTo(map)

// set choropleth params from metersOut in outageValues
function getColor(percentOut) {
    return percentOut > 75 ? '#FF0000' :
        percentOut > 50 ? '#FFA500' :
            percentOut > 25 ? '#FFFF00' :
                percentOut > 1 ? '#7CFC00' :
                        'grey';
}

// call outage data from php generated object "outageValues" and apply to polygon

function style(feature) {

    let percentOut = percentValues[feature.properties.town];

    return {
        fillColor: getColor(percentOut),
        weight: 1,
        opacity: 1,
        color: 'black',
        fillOpacity: 0.3
    };
}
L.geoJson(serviceTowns, { style: style }).addTo(map);


// create hover hightlight and townname feature ////////

function highlightFeature(e) {

    let layer = e.target;

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
// End highlight //////


//  Onclick gets townname with # of members affected and % of town affected ////////
function popUpClick(feature, layer) {
    let props = feature.properties;
    if (props) {
        let metersOut = (outageValues[props.town] ? outageValues[props.town] : 0);
        let percentOut = (percentValues[props.town] ? percentValues[props.town] : 0);
        let town = feature.properties.townMC;
    
    if (props) {
        (layer.bindPopup(('<h3>' + town + '</h3><p># of members affected: ' + metersOut + '<br/>' + percentOut + '% of ' + town + ' affected')))
    }
}}
// Define hover and click events
function onEachFeature(feature, layer) {

    let popup = popUpClick(feature, layer);


    // Set click params and generate popup for click ///////////
    layer.on({
        click: popup,
        mouseover: highlightFeature,
        mouseout: resetHighlight
    });
}

//End Mouse functions ///

// Keep json layer fresh ////
geojson = L.geoJson(serviceTowns, {
    style: style,
    onEachFeature: onEachFeature,
}).addTo(map);

// ////
// Add Info pane to map div ////////
// ///////

var info = L.control();

info.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
    this.update();
    return this._div;
};

// call town data from outageValues and display in infopane
info.update = function (props) {


    // parse data from php db
    if (props) {
        metersOut = (outageValues[props.town] ? outageValues[props.town] : 0);
        percentOut = (percentValues[props.town] ? percentValues[props.town] : 0);
        town = props.townMC;
    }

    let message = 'Hover over a town';
    if (props) {
        message = (metersOut + ' Members affected in ' + town + '<br/>' + percentOut + '% of ' + town + ' affected' + '<br/>'
        );
    }

    this._div.innerHTML = '<h4>VEC Service Territory</h4>' + message;
};

info.addTo(map);

// ////////////
// create legend in bottom and call colors from choropleth params set in getColor function

const legend = L.control({ position: 'bottomleft' });

legend.onAdd = function (map) {

    let div = L.DomUtil.create('div', 'info legend'),
        grades = [1, 25, 50, 75],
        labels = [],
        from, to;

    labels.push('<p>% of Town<br/>Affected</p><br/><i style="background: grey"></i> ' + '0');   // title and trick legend into showing null value for grey
    for (let i = 0; i < grades.length; i++) {
        from = grades[i];
        to = grades[i + 1];

        div.innerHTML =
            labels.push(
               '<i style="background:' + getColor(from + 1) + '"></i> ' + from + (to ? '&ndash;' + to : '&ndash;100'));
    }
    div.innerHTML = labels.join('<br>');
    return div;
};

legend.addTo(map);


////// features diabled

// map.dragging.disable();
// map.touchZoom.disable();
map.doubleClickZoom.disable();
map.scrollWheelZoom.disable();