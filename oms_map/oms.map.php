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
$sortBy = array('town');

$order = 'off';
if (isset($_GET['sortBy']) && in_array($_GET['sortBy'], $sortBy)) {
    $order = $_GET['sortBy'];
}

//Select # of live outages
$outageDataSql = "SELECT * FROM oms_by_town_live_percent ORDER BY " . $order;

$outageDataResult = mysqli_query($conn, $outageDataSql);
$numOutageData = mysqli_num_rows($outageDataResult);

$outageData = [];
while ($row = mysqli_fetch_assoc($outageDataResult)) {

    $outageData[$row['town']] = $row;
}

$outageValues = [];

foreach ($outageData as $outage) {

    $outageValues[$outage['town']] = $outage['out'];
}
foreach ($outageData as $percent) {

    $outageValues[$percent['town']] = $percent['percent'];
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>VEC Outage Center</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="leaflet.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
    <script src="serviceTowns.js"></script>
    <link rel="stylesheet" href="leaflet.css" />
    <link rel="stylesheet" href="map.css" />

</head>

<body>
 <!----------------- Map area ---------------------->
<div id="mapid"></div>


      <script type="text/javascript">
        var outageValues = JSON.parse(<?php echo "'" . json_encode($outageValues) . "'"; ?>);
      </script>


    <!----------------- Current Outages Table ------------------------>
    <div id="outTable">
            <?php

$resultID = mysqli_query($conn, $outageDataSql);
for ($x = 0; $x < mysqli_num_rows($resultID); $x++) {

    $ascdesc = ($_GET['ad']) ? 'asc' : 'desc';
    $row = mysqli_fetch_assoc($resultID);
    $out = $row['out'];
    $percent = round($row['percent'], 2);
    $town = $row['town'];
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
    <td bgcolor='#f5f5f5'>$out</td>
    <td>$off</td>
    <td bgcolor='#f5f5f5'>$etr</td>
    <td>$percent</td>
    </tr>";
}

echo "<table align=center width=90% cellpadding=3>\n";
echo "<tr class='cTable'>
    <th bgcolor='#1682c8'><a href='?sortBy=town&ad='" . $ascdesc . "'><font color='white'>Town</font></a></th>
    <th bgcolor='#1682c8'><font color='white'># of Member<br>Outages</font></th>
    <th bgcolor='#1682c8'><font color='white'>Time Off</font></th>
    <th bgcolor='#1682c8'><font color='white'>Estimated<br>Restoration Time</font></th>
    <th bgcolor='#1682c8'><font color='white'>Percent Out</font></th>
    </tr>\n";
echo $current;
"\n";
echo "</table>";

?>

    </div>

<script src="mapScripts.js"></script>
</body>


</html>