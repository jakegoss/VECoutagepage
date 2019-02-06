<!-- this is the map build with a current outage table to be placed in a frame module -->
<!-- Connect to a local database to access updated data -->

<?php

$host = "localhost";
$user = "vec_oms";
$pass = "i2NoTgNkB9am";
$database = "vec_oms";

$conn = mysqli_connect($host, $user, $pass, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//Outage Data
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
    <script src="leaflet.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
    <script src="serviceTowns.js"></script>
    <script src="townMeters.js"></script>
    <link rel="stylesheet" href="leaflet.css" />
    <link rel="stylesheet" href="map.css" />

</head>

<body>

    <!----------------- Current Outages Table ------------------------>
    <div id="outTable">
            <?php

$resultID = mysqli_query($conn, $outageDataSql);
for ($x = 0; $x < mysqli_num_rows($resultID); $x++) {
    $row = mysqli_fetch_assoc($resultID);
    $out = $row['out'];
    $town = $row['town'];
    //    $tk = $row['tk'];
    $off = $row['off'];
    $off = date("m/d h:ia", strtotime($off));
    $etr = $row['etr'];
    if ($etr != null) {
        $etr = date("m/d h:ia", strtotime($etr));
    } else {
        $etr = "TBD";
    }
    $current = $current . "<tr>
    <td>$town</td>
    <td>$out</td>
    <td>$off</td>
    <td>$etr</td>
    <td>";
}

echo "<table width=70% cellpadding=4>\n";
echo "<tr>
    <th bgcolor='#cccccc'>Town</th>
    <th bgcolor='#cccccc'># of Meter<br>Outages</td>
    <th bgcolor='#cccccc'>Time Off</th>
    <th bgcolor='#cccccc'>Estimated<br>Restoration Time</th>
    </tr>\n";
echo $current;
"\n";
echo "</table>";

?>

    </div>

    <!----------------- Map area ---------------------->
    <div id="mapid"></div>


      <script type="text/javascript">
        var outageValues = JSON.parse(<?php echo "'" . json_encode($outageValues) . "'"; ?>);
      </script>


<script src="mapScripts.js"></script>
</body>


</html>