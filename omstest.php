<?php
include_once 'lib/dbh.oms.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>OMS submit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
</head>
<body>

<!-- input new outages -->
<div>
    Town<input type="text"><br/>
    <br/>
    Time Off<input type="datetime-local"><br/>
    <br/>
    Estimated Restoration Time<input type="datetime-local"><br/>
    <br/>
    Meter#<input type="number"><br/>
    <br/>
    Cause<input type="text"><br/>
    <br/>
    Equipment Code<input type="text">

</div>

<!-- display table of outages -->

<?php

$sql = "SELECT * FROM outagedata;";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);

if ($resultCheck > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo $row['town'] . "<br>";
    }
}

?>


</body>
</html>




