<?php
include_once "lib/dbh.oms.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Map</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="map.css" />
    <link rel="stylesheet" href="lib/leaflet.css" />
    <script src="lib/leaflet.js"></script>
    <script src="cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
         <script type="text/javascript">
            $(document).ready(function(){
               $('.striped tr:even');
            });
        </script>

</head>

<body class="container">
    <!----------------- Map area ---------------------->
    <div id="mapid"></div>
    
    
    <script src="lib/serviceTowns.js"></script>
    <script src="mapScripts.js"></script>
    
    <!----------------- Limited Table area ------------------------>







</body>


</html>