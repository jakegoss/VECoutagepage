<?php
include_once "lib/dbh.oms.php";

//Outage Data
$outageDataSql = "SELECT * FROM outagedata;";
$outageDataResult = mysqli_query($conn, $outageDataSql);
$numOutageData = mysqli_num_rows($outageDataResult);

$outageData = [];
while ($row = mysqli_fetch_assoc($outageDataResult)) {

    $outageData[$row['id']] = $row;
}

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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
    <script src="lib/townMeters.js"></script>
    <script src="lib/serviceTowns.js"></script>
</head>

<body class="container">

    <!----------------- Limited Table area ------------------------>
    <div id="outTable">

        <!-- <h2>Current Outages in Vermont Electric COOP service area</h2> -->


        <table style="text-align: center">
            <tr class="header" style="font-weight:bold">
                <th>Town</th>
                <th># of Meters</th>
                <th>Time Out</th>
                <th>Estimated<br/>Restoration Time</th>
            </tr>

            <?php

if ($numOutageData > 0) {

    foreach ($outageData as $outage) {
        echo "<tr>";
        echo "<td>" . $outage['townMC'] . "</td>";
        echo "<td>" . $outage['metersOut'] . "</td>";
        echo "<td>" . $outage['timeOut'] . "</td>";
        echo "<td>" . $outage['estRestTime'] . "</td>";
        echo "</tr>";
    }

} else {
    echo $message;
    echo '<script type="text/javascript">$("#outTable").hide()</script>';
}

?>

        </table>

    </div>

    <!----------------- Map area ---------------------->
    <div id="mapid"></div>

    <script type="text/javascript">
      var outageData = JSON.parse('<?php echo json_encode($outageData); ?>'); 
     
      </script>
        
      <script src="lib/outageDataX.js"></script>
      <script src="dataMerge.js"></script>
      <script src="mapScripts.js"></script>

    <!----------------- Full Data Table ---------------------->

    <div id="restTable">


        <table style="text-align: center">
            <tr class="header" style="font-weight:bold">
                <!-- <td>Ticket</td> -->
                <th>Town</th>
                <th># of Meters</th>
                <th>Time Out</th>
                <th>Time On</th>
                <th>Cause</th>
                <!-- <td>Equipment Code</td> -->
            </tr>

            <?php

if ($numOutageData > 0) {

    foreach ($outageData as $outage) {

        echo "<tr>";
        echo "<td>" . $outage['townMC'] . "</td>";
        echo "<td>" . $outage['metersOut'] . "</td>";
        echo "<td>" . $outage['timeOut'] . "</td>";
        echo "<td>" . $outage['timeOn'] . "</td>";
        echo "<td>" . $outage['cause'] . "</td>";
        echo "</tr>";
    }

} else {

    echo '<script type="text/javascript">$("#restTable").hide()</script>';

}

?>

</div>


</body>


</html>