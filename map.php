<!-- this is the map build alone to be placed in a frame module -->
<!-- Connect to a local database to access updated data -->

<?php



//Gather Outage Data for use in Map
$outageDataSql = "SELECT * FROM oms_by_town_live;";
$outageDataResult = mysqli_query($conn, $outageDataSql);
$numOutageData = mysqli_num_rows($outageDataResult);

$outageData = [];
while ($row = mysqli_fetch_assoc($outageDataResult)) {

    $outageData[$row['id']] = $row;
}

$outageValues = [];

foreach ($outageData as $outage) {

    $outageValues[$outage['town']] = $outage['out'];
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>VEC Outage Reports</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="map.css" />
    <link rel="stylesheet" href="leaflet.css" />
    <script src="leaflet.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
    <script src="townMeters.js"></script>
    <script src="serviceTowns.js"></script>

</head>

<body class="container">


    <!----------------- Map area ---------------------->
    <div id="mapid"></div>


      <script type="text/javascript">
        var outageValues = JSON.parse(<?php echo "'" . json_encode($outageValues) . "'"; ?>);
      </script>


<script src="mapScripts.js"></script>
</body>


</html>