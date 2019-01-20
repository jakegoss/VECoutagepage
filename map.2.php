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
    <link rel="stylesheet" href="lib/map.css" />
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

    <!----------------- Limited Table area ------------------------>
    <div id="smallOutTbl">

        <!-- <h2>Current Outages in Vermont Electric COOP service area</h2> -->
        <?php

$sql = "SELECT * FROM outagedata;";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);

?>
        <table class="striped" style="text-align: center">
            <tr class="header" style="font-weight:bold">
                
                <td>Town</td>
                <td># of Meters</td>
                <td>Time Out</td>
                <td>Estimated Restoration Time</td>
                
            </tr>
            <?php

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['town'] . "</td>";
    echo "<td>" . $row['numout'] . "</td>";
    echo "<td>" . $row['off'] . "</td>";
    echo "<td>" . $row['eston'] . "</td>";
    echo "</tr>";
    
}
if($resultCheck == 0) echo "<h3>There are not outages at this time</h3>";


?>
        </table>

    </div>

    <!----------------- Map area ---------------------->
<?php

$sql = "SELECT * FROM outagedata;";
$result = mysqli_query($conn, $sql);

$json_array = array();

while ($row = mysqli_fetch_assoc($result)) {
    $json_array[] = $row;
}

?>  

    <div id="mapid"></div>
    
    
    
    
    <!----------------- Full Data Table ---------------------->
    
    <div id="bigOutTbl">

        
        <?php

$sql = "SELECT * FROM outages;";
$result = mysqli_query($conn, $sql);
// $resultCheck = mysqli_num_rows($result);

?>
        <table class="striped" style="text-align: center">
            <tr class="header" style="font-weight:bold">
                <td>Town</td>
                <td># of Meters</td>
                <td>Time Out</td>
                <td>Time On</td>
                <td>Cause</td>

            </tr>
            <?php

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    // echo "<td>" . $row['tk'] . "</td>";
    echo "<td>" . $row['town'] . "</td>";
    echo "<td>" . $row['numout'] . "</td>";
    echo "<td>" . $row['off'] . "</td>";
    echo "<td>" . $row['backon'] . "</td>";
    echo "<td>" . $row['cause'] . "</td>";
    // echo "<td>" . $row['equipcode'] . "</td>";
    echo "</tr>";
    
}
// if($result == 0) echo "<h3>There are not outages at this time</h3>";


?>
        </table>

    </div>

    <script src="lib/serviceTowns.js"></script>
    <script src="mapScripts.js"></script>
</body>


</html>