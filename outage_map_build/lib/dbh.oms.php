<?php

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "outagedata";


// $dbServername = "localhost";
// $dbUsername = "vec_oms";
// $dbPassword = "i2NoTgNkB9am";
// $dbName = "vec_oms";


$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "<h3>Being prepared for outages is important, especially during weather related outages where damage can be widespread and repairs may be complex. Having a plan and an emergency outage kit are good ideas for everyone to consider.  Outage kits should be kept in an accessible location, and should provide for basic needs. Also, please check on elderly neighbors and relatives.</h3>";