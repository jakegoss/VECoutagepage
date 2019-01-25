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
    <!-- <script src="cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> -->
    <!-- <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" /> -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
 
</head>

<body class="container">

    <!----------------- Limited Table area ------------------------>
    <div id="smallOutTbl">

        <!-- <h2>Current Outages in Vermont Electric COOP service area</h2> -->

    
        <table id="outTable" class="striped" style="text-align: center">
            <tr class="header" style="font-weight:bold">
                <td>Town</td>
                <td># of Meters</td>
                <td>Time Out</td>
                <td>Estimated Restoration Time</td>
            </tr>
       
            <?php

            if ($numOutageData > 0) {

                foreach ($outageData as $outage) {
                    echo "<tr>";
                    echo "<td>" . $outage['town'] . "</td>";
                    echo "<td>" . $outage['numout'] . "</td>";
                    echo "<td>" . $outage['off'] . "</td>";
                    echo "<td>" . $outage['eston'] . "</td>";
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
    <script src="lib/serviceTowns.js"></script>
    
    <script type="text/javascript">
      var outageData = JSON.parse('<?php echo json_encode($outageData);?>');
      </script>
      <script src="mapScripts.2.js"></script>
    
<!-- <script src="lib/serviceTowns.js"></script> -->

    <!----------------- Full Data Table ---------------------->

    <div id="bigOutTbl">

 
        <table id="restTable" class="striped" style="text-align: center">
            <tr class="header" style="font-weight:bold">
                <!-- <td>Ticket</td> -->
                <td>Town</td>
                <td># of Meters</td>
                <td>Time Out</td>
                <td>Time On</td>
                <td>Cause</td>
                <!-- <td>Equipment Code</td> -->
            </tr>
        
            <?php

if ($numOutageData > 0) {

    foreach ($outageData as $outage)  {

                    echo "<tr>";
                    echo "<td>" . $outage['town'] . "</td>";
                    echo "<td>" . $outage['numout'] . "</td>";
                    echo "<td>" . $outage['off'] . "</td>";
                    echo "<td>" . $outage['backon'] . "</td>";
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
