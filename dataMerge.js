// var obj1 = outageData;
// var dataObject = Object.assign(serviceTowns, obj1);

for (var x = 0; x < outageDataX.length; x++) {
  if(x === 'town' && outageDataX[x].hasOwnProperty('metersOut')) {
      outageDataX[x].metersOut = '20';
  }
}

// var outageData in map.2.php is DB data used to update outages. serviceTowns is Object with polygons and all pre-existing properties to be updated. Some properties do not get updated i.e. townName, geo, etc, while outage data is what will dynamically updated, but never needs multiple values. 

// need something like the above to update values of metersOut for town in serviceTowns when data from "outageData" exists in table. Conditional loop that checks townName then update metersOut for that town. 

// outageDataX is static test object for attempt to understand js object manipulation 