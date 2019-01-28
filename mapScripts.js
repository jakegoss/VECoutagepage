// set initial map view point
var map = L.map('mapid').setView([44.5, -72.6034], 8);

// add map tile layer and set max zoom
L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href=”http://osm.org/copyright”>OpenStreetMap</a> contributors',
    maxZoom: 11,
}).addTo(map);


// add town polygon
L.geoJson(serviceTowns, {
    color: 'black',
    fillColor: "",
    weight: '0.7',
    zindex: '1',
    
}).addTo(map);


  //define color of town by # of meters out
  function colorChoropleth(d){
    return  d > 500  ? '#FF0000' :
    d > 100  ? '#FFA500' :
    d > 50   ? '#FFFF00' :
    d > 1    ? '#7CFC00' :
    d > 0    ? '#0000FF' :
    'orange';
  }

  //define how our point data will be visualized
  function style(style) {
    return {
        fillColor: colorChoropleth(style),
        weight: 1,
        opacity: 1,
        color: 'white',
        fillOpacity: 0.7
    };
}

L.geoJson(serviceTowns, {style: style(colorChoropleth)}).addTo(map);


// TOWN HIGHLIGHT FEATURE AND town POPUP

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
        layer.bindPopup(layer.feature.properties.townName);
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

geojson = L.geoJson(serviceTowns, {
    style: style,
    onEachFeature: onEachFeature,
}).addTo(map);





// //// features diabled

// map.dragging.disable();
// map.touchZoom.disable();
map.doubleClickZoom.disable();
map.scrollWheelZoom.disable();