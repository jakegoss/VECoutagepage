// set initial map view point
var map = L.map('mapid').setView([44.5, -72.6034], 8);

// add map tile layer and set max zoom
L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href=”http://osm.org/copyright”>OpenStreetMap</a> contributors',
    maxZoom: 11,
}).addTo(map);


// add town polygon
let townBoundaries = L.geoJson(outTowns, {
    color: '#000',
    fillColor: 'grey',
    weight: '0.7',
    zindex: '2',
}).addTo(map)



// set choropleth color params

      function colorPleth(numout){
        return  numout > 500  ? '#FF0000' :
        numout > 100  ? '#FFA500' :
        numout > 50   ? '#FFFF00' :
        numout > 1    ? '#7CFC00' :
        numout > 0    ? '#0000FF' :
                 'grey';
      }


// function style(feature) {
    return {
        fillColor: colorPleth(numout),
        weight: 1,
        opacity: 1,
        color: 'grey',
        fillOpacity: 0.3
    };

// define how Pleth will be visualized
function stylePleth(feature){
    return {
      fillColor: colorPleth(feature.properties.numout),
      color: '#grey',
    };

// create empty geojson to style
var geojson = L.geoJson(null,{
    pointToLayer:function(feature,latlng){
        return L.polygon(latlng,stylePleth(feature));
    }
}).addTo(map);

//fetch the geojson and add it to our geojson layer
getGeoData(JSON.parse).then(data => geojson.addData(data));

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



// add info pane to map 
var info = L.control();

info.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
    this.update();
    return this._div;
};

// display town name and outage data in info pane
info.update = function (properties) {
 
    this._div.innerHTML = '<h4>Current number of Outages in</h4>' +  (properties ?
        '<b>' + properties.town + '</b><br />' + JSON.parse.numout
        : 'Click on a town');
};

info.addTo(map);








// //// features diabled

// map.dragging.disable();
// map.touchZoom.disable();
map.doubleClickZoom.disable();
map.scrollWheelZoom.disable();