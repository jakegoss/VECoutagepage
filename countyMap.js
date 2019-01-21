
let mymap = L.map('mapid', {zoomControl: false, }).setView([44.0423, -72.6034], 8);


L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/rastertiles/voyager/{z}/{x}/{y}{r}.png', 
            'http://{s}.basemaps.cartocdn.com/light_only_labels/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="http://cartodb.com/attributions">CartoDB</a>',
                subdomains: 'abcd',
                maxZoom: 19,
                id: 'mapbox.streets',

}).addTo(mymap); 
mymap.createPane('labels');
mymap.getPane('labels').style.zIndex = 650;
mymap.getPane('labels').style.pointerEvents = 'none';




var positronLabels = L.tileLayer('http://{s}.basemaps.cartocdn.com/light_only_labels/{z}/{x}/{y}.png', {
        attribution: '©OpenStreetMap, ©CartoDB',
        pane: 'labels'
}).addTo(mymap);
 
    
let townBoundaries
let countyBoundaries = L.geoJson(countyPolygons, {
        fillColor: '#1D4F1A',
        weight: 2,
        opacity: 1,
        color: 'black',
        dashArray: '',
        fillOpacity: 0.6,
}).addTo(mymap)

function createChoropleth() {
    //inserts that data into the polygon objects.
    let dataType = 
    document.getElementById('trashRadio').checked ? 'trash' :
    document.getElementById('teamRadio').checked ? 'teams' :
    'users'

if (level === 'state') {
    createCountypleth(dataType);
} 
else if (level === 'county') {
    createTownpleth(dataType)
} else if (level === 'town') {
    createTownpleth(dataType)
}
killTheLegend()
makeLegends(dataType)

info.update()
}

function createTownpleth(dataType) {
    for(let county in vermont.counties){
        county = vermont.counties[county]
        for(let town in county.towns){
            town = county.towns[town]
            for(let townPolygon in townPolygons.features){
                townPolygon = townPolygons.features[townPolygon]
                if (townPolygon.properties.TOWNNAME.toLowerCase() == town.name){
                    townPolygon.properties.choroplethData = (dataType === 'trash')  ? town.stats.bagCount : (dataType === 'teams') ? town.stats.totalTeams : town.stats.userActivity; 
                    break
                }
            }
        }
    }
    createTownMap()
}

function createCountypleth(dataType) {
    let counties = countyPolygons.features;
    for (let countyIndex in counties) {
        let targetCounty = counties[countyIndex].properties.CNTYNAME.toString().toLowerCase();
        counties[countyIndex].properties.choroplethData = (dataType === 'trash') ? bagCountOf(targetCounty) : (dataType === 'teams') ? teamCountOf(targetCounty) : userCountOf(targetCounty);
    }
    mymap.removeLayer(countyBoundaries);
    countyBoundaries = L.geoJson(countyPolygons, {
        style: style,
        onEachFeature: onEachFeature
    }).addTo(mymap);
}

function bagCountOf(county) {
    return vermont.counties[county].stats.bagCount
}

function teamCountOf(county) {
    return vermont.counties[county].stats.totalTeams
}

function userCountOf(county){
    return vermont.counties[county].stats.userActivity
}

function getLocalColor(l) {
    return l > 27 ? '#001333' :
    l > 25 ? '#001c4c' :
    l > 23 ? '#012768' :
    l > 21 ? '#02358c' :
    l > 19 ? '#0b3b8c' :
    l > 17 ? '#15428e' :
    l > 15 ? '#1c468e' :
    l > 13 ? '#244c91' :
    l > 11 ? '#2e5496' :
    l > 9 ? '#3a5e9e' :
    l > 7 ? '#4768a3' :
    l > 5 ? '#5775aa' :
    l > 3 ? '#6d89ba' :
    l > 1 ? '#7f98c4' :
    l > 0 ? '#a3bae2' :
    l === 0 ?'#edf3ff':
    '#000000';
}
function localStyle(feature) {
    return {
        fillColor: getLocalColor(feature.properties.choroplethData),
        weight: 2,
        opacity: 1,
        color: 'black',
        dashArray: '',
        fillOpacity: 1 
    };
}
function getColor(d) {
    return d > 27 ? '#043300' :
    d > 25 ? '#10410D' :
    d > 23 ? '#1D4F1A' :
    d > 21 ? '#295D27' :
    d > 19 ? '#366B34' :
    d > 17 ? '#427941' :
    d > 15 ? '#4c874b' :
    d > 13 ? '#5C955B' :
    d > 11 ? '#68A368' :
    d > 9 ? '#75B175' :
    d > 7 ? '#81BF82' :
    d > 5 ? '#8ECD8F' :
    d > 3 ? '#9ADB9C' :
    d > 1 ? '#A7E9A9' :
    d > 0 ? '#B4F8B6' :
    d === 0 ?'#f7fff7':
    '#000000';
}

function style(feature) {
    return {
        fillColor: getColor(feature.properties.choroplethData),
        weight: 2,
        opacity: 1,
        color: 'black',
        dashArray: '',
        fillOpacity: 0.8
    };
}

function highlightFeature(e) {
    var layer = e.target;
    
    layer.setStyle({
        weight: 3,
        color: 'black',
        dashArray: '',
        fillOpacity: .7
    });
    
    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
        layer.bringToFront();
    }
    info.update(layer.feature.properties)
}

function resetHighlight(e) { 
    let townName = e.target.feature.properties.TOWNNAME
    if (!townName){
    countyBoundaries.resetStyle(e.target);
    info.update()
    } else if (townName){
    townBoundaries.resetStyle(e.target)
    info.update()
    }
}
function controlBackBtnVisibility(level){
    
    if (level === "state") {
        document.getElementById('zoomBtn').style.display = 'none'     
    } else if (level === 'county') {
        document.getElementById('zoomBtn').style.display = 'block'
    } else if (level === 'town') {
        document.getElementById('zoomBtn').style.display = 'block'
    }
}
function handleBackClick(){
// event.preventDefault()

    mymap.setView([44.0423, -72.6034], 8)
    level ='state'
    mymap.removeLayer(townBoundaries)
    updateLabels()
    makeChart()
    updateOdometer()
    createChoropleth()
    controlBackBtnVisibility(level)
    // killTheLegend()
    // makeLegends()
    currentTown = undefined
}

function handleChoroplethClick(e) {
    let townName = e.target.feature.properties.TOWNNAME
    mymap.fitBounds(e.target.getBounds());
    currentCounty = e.target.feature.properties.CNTY
    if (townName) {
    currentTownName = townName.toLowerCase()
    currentTown = vermont.countyNumber(currentCounty).towns[currentTownName]
    }
    level = (townName ? 'town' : 'county')
    controlBackBtnVisibility(level)
    createChoropleth()
// update the info. 
    updateLabels()
    makeChart()
    updateOdometer()
    // killTheLegend()
    // makeLegends()

}

function onEachFeature(feature, layer) {
    layer.on({
        mouseover: highlightFeature,
        mouseout: resetHighlight,           //MAYBE WE CAN REMOVE THIS AND RESET HIGHLIGHT????
        click: handleChoroplethClick
    });
}

var info = L.control();

info.onAdd = function (mymap) {
    this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"

    this.update();
    return this._div;
};

// method that we will use to update the control based on feature properties passed
info.update = function (props) {
    let dataType = 
    document.getElementById('trashRadio').checked ? 'trash' :
    document.getElementById('teamRadio').checked ? 'teams' :
    'users'

    if (level === 'state'){
        updateInfoBoxAtStateLevel(dataType, props);
    }
    else {
        updateInfoAtCountyAndTown(dataType, props);
    }
    
}

function updateInfoAtCountyAndTown(dataType, props) {
    if (dataType === 'trash') {
        info._div.innerHTML = '<h4>' + 'Total Number of Bags by Town' + '</h4>' + (props && props.TOWNNAME ?
            '<b>' + props.TOWNNAME + '</b><br />' + props.choroplethData + ' ' + 'Bags' : 'Hover over a Town');
    }
    else if (dataType === 'users') {
        info._div.innerHTML = '<h4>' + 'Total Number of Users by Town' + '</h4>' + (props && props.TOWNNAME ?
            '<b>' + props.TOWNNAME + '</b><br />' + props.choroplethData + ' ' + 'Users' : 'Hover over a Town');
    }
    else if (dataType === 'teams') {
        info._div.innerHTML = '<h4>' + 'Total Number of Teams by Town' + '</h4>' + (props && props.TOWNNAME ?
            '<b>' + props.TOWNNAME + '</b><br />' + props.choroplethData + ' ' + 'Teams' : 'Hover over a Town');
    }
}

function updateInfoBoxAtStateLevel(dataType, props) {
    if (dataType === 'trash') {
        info._div.innerHTML = '<h4>' + 'Total Number of Bags by County' + '</h4>' + (props ?
            '<b>' + props.CNTYNAME + '</b><br />' + props.choroplethData + ' ' + 'Bags' : 'Hover over a County');
    }
    else if (dataType === 'users') {
        info._div.innerHTML = '<h4>' + 'Total Number of Users by County' + '</h4>' + (props ?
            '<b>' + props.CNTYNAME + '</b><br />' + props.choroplethData + ' ' + 'Users' : 'Hover over a County');
    }
    else if (dataType === 'teams') {
        info._div.innerHTML = '<h4>' + 'Total Number of Teams by County' + '</h4>' + (props ?
            '<b>' + props.CNTYNAME + '</b><br />' + props.choroplethData + ' ' + 'Teams' : 'Hover over a County');
    }
}

function createTownMap(){
    
    if (townBoundaries) {mymap.removeLayer(townBoundaries)};
    townBoundaries = L.geoJson(townPolygons, {
        style: localStyle,
        onEachFeature: onEachFeature,
        filter: (feature, layer) => {
           return (feature.properties.CNTY === currentCounty ? true : false)
           
        }
    }).addTo(mymap);
}

mymap.dragging.disable();
mymap.touchZoom.disable();
mymap.doubleClickZoom.disable();
mymap.scrollWheelZoom.disable();


info.addTo(mymap);

