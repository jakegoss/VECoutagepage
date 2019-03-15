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
// $sortBy = array('town');

// $order = 'off';
// if (isset($_GET['sortBy']) && in_array($_GET['sortBy'], $sortBy)) {
//     $order = $_GET['sortBy'];
// }

//Select # of live outages
// $outageDataSql = "SELECT * FROM oms_by_town_live_percent ORDER BY " . $order;
$outageDataSql = "SELECT * FROM oms_by_town_live_percent ";

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

$percentValues = [];

foreach ($outageData as $percent) {

    $percentValues[$percent['town']] = round($percent['percent'], 2);
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
        var percentValues = JSON.parse(<?php echo "'" . json_encode($percentValues) . "'"; ?>);
      </script>


    <!----------------- Current Outages Table ------------------------>
    <div id="outTable">
            <?php

$resultID = mysqli_query($conn, $outageDataSql);
for ($x = 0; $x < mysqli_num_rows($resultID); $x++) {

    // $order = ($_GET['ad']) ? 'asc' : 'desc';
    $row = mysqli_fetch_assoc($resultID);
    $out = $row['out'];
    $percent = round($row['percent'], 2);
    $town = $row['town'];
    $off = $row['off'];
    $off = str_replace(array('am','pm'),array(' a.m.',' p.m.'),date("n/j g:ia", strtotime($off)));
    $etr = $row['etr'];
    if ($etr != null) {
        $etr = str_replace(array('am','pm'),array(' a.m.',' p.m.'),date("n/j g:ia", strtotime($etr)));
    } else {
        $etr = "TBD";
    }

    $current = $current . "<tr>
    <td align=center><font size=3>$town</font></td>
    <td align=center bgcolor='#f5f5f5'><font size=3>$out</font></td>
    <td align=center><font size=3>$off</font></td>
    <td align=center bgcolor='#f5f5f5'><font size=3>$etr</font></td>
    <td align=center><font size=3>$percent</font></td>
    </tr>";
}

echo "<table align=center width=90% cellpadding=3>\n";
echo "<tr class='cTable'>
    <th bgcolor='#1682c8'><font color='white' size=3>Town</font></th>
    <th bgcolor='#1682c8'><font color='white' size=3># of Member<br>Outages</font></th>
    <th bgcolor='#1682c8'><font color='white' size=3>Time Off</font></th>
    <th bgcolor='#1682c8'><font color='white' size=3>Estimated<br>Restoration Time</font></th>
    <th bgcolor='#1682c8'><font color='white' size=3>Percent Out</font></th>
    </tr>\n";
echo $current;
"\n";
echo "</table>";

?>

    </div>

<script src="mapScripts.js"?=v31></script>
</body>


</html>