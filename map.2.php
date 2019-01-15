<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Map</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="lib/leaflet.css" />
    <link rel="stylesheet" href="map.css" />
    <script src="lib/leaflet.js"></script>
    <script src="cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />

</head>

<body>

    <!----------------- Data Table area ------------------------>
    <div id="outages">

        <h2>Current Outages in Vermont Electric COOP service area</h2>

        

        <?php
        include 'omstest.php';
        // echo build_table($array);
    ?>
    </div>

    <!----------------- Map area ---------------------->
    <div id="mapid"></div>


    <script src="lib/serviceTowns.js"></script>
    <script src="mapScripts.js"></script>
</body>


</html>