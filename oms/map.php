<!-- this is the map build with a current outage table to be placed in a frame module -->
<!-- Connect to a local database to access updated data -->

<?php

$host  = "localhost";
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
    <link rel="stylesheet" href="map.css" />
    <link rel="stylesheet" href="leaflet.css" />
    <script src="leaflet.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
    <script src="serviceTowns.js"></script>
    <script src="townMeters.js"></script>

</head>

<body class="container">

    <!----------------- Current Outages Table ------------------------>
    <div id="outTable">

<!-- <Table class="outage" border='0' cellspacing='1' cellpadding='3' width=100%>   
    <thead >
<tr>
    <th bgcolor='#cccccc' ><font  size=2>Town</font></th>
    <th bgcolor='#cccccc' ><font  size=2>#M</font></th>
    <th bgcolor='#cccccc'><font  size=2>Time Off</font></th>
    <th bgcolor='#cccccc'><font  size=2>Estimated Restoration Time</font></th>
    <th bgcolor='#cccccc'><font  size=2>Time on</font></th>
    <th bgcolor='#cccccc'><font  size=2>Cause</font></th>
    <th bgcolor='#cccccc'><font  size=2>Desc.</font></th>
    <th bgcolor='#cccccc'><font  size=2>Ticket#</font></th>
</tr>
</thead> -->
            <?php

$resultID = mysqli_query($conn, $outageDataSql);
for($x = 0 ; $x < mysqli_num_rows($resultID) ; $x++){
    $row = mysqli_fetch_assoc($resultID);
        $out = $row['out'];
       $town = $row['town'];
       $tk = $row['tk'];
       $off = $row['off'];
       $off = date("m/d h:ia", strtotime($off));
      $etr = $row['etr'];
      if ($etr != NULL) {
               $etr = date("m/d h:ia", strtotime($etr));
      } else {
            $etr = "TBD";
      }
       $current = $current . "<tr><td><font size=2>$town</font></td><td><font size=2>$out</font></td><td><font size=2>$off</font></td><td><font size=2>$etr</font></td><td><font size=2>$tk</font></td></tr>\n";
	}
    echo "<b>Total Outages: $outage_count</b><br>";
    echo "<b>Total Members Out: $total</b><br>\n";
    echo "<b>Current Outages By Town:</b><br>";
    echo "<table width=50% cellpadding=3>\n";
    echo "<tr><th bgcolor='#cccccc' align=left ><font size=2>Town</font></th><th bgcolor='#cccccc'><font size=2>#M</font></td><th bgcolor='#cccccc' align=left><font   size=2>Time Off</font></th><th bgcolor='#cccccc' align=left><font size=2>Estimated<br>Restoration Time</font></th><th bgcolor='#cccccc' align=left><font   size=2>Ticket#</font></th></tr>\n";
    echo $current;
    echo "</table>";
  

?>
        </table>

    </div>

    <!----------------- Map area ---------------------->
    <div id="mapid"></div>


      <script type="text/javascript">
        var outageValues = JSON.parse(<?php echo "'" . json_encode($outageValues) . "'"; ?>);
      </script>


<script src="mapScripts.js"></script>
</body>


</html>