<?php
include_once "lib/dbh.oms.php";
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

<!-- display table of outages -->

<?php

$sql = "SELECT * FROM outagedata;";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
$outs = array();
if ($resultCheck > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $outs[] = $row;
    }
}

foreach ($outs[1] as $out) {
    echo $out . " ";
}
foreach ($outs as $out) {
    echo $out['tk'] . "<br>";
}


?>


</body>
</html>




