// set initial map view point
var map = L.map('mapid').setView([44.5, -72.6034], 8);

// add map tile layer and set max zoom
L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href=”http://osm.org/copyright”>OpenStreetMap</a> contributors',
    maxZoom: 11,
}).addTo(map);

console.log(object.values(outageData));

appendTo

// add town polygon
L.geoJson(serviceTowns, {
    color: 'black',
    fillColor: "",
    weight: '0.7',
    zindex: '1',
    
}).addTo(map);

const mapData = outageData.concat(serviceTowns); 

  //define color of town by # of meters out
  function colorChoropleth(numout){
    return  Object.values(numout) > 500  ? '#FF0000' :
    Object.values(numout) > 100  ? '#FFA500' :
    Object.values(numout) > 50   ? '#FFFF00' :
    Object.values(numout) > 1    ? '#7CFC00' :
    Object.values(numout) > 0    ? '#0000FF' :
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

L.geoJson(mapData, {style: style(colorChoropleth)}).addTo(map);



// //// features diabled

// map.dragging.disable();
// map.touchZoom.disable();
map.doubleClickZoom.disable();
map.scrollWheelZoom.disable();