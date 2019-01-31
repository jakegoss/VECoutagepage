<?php
header('Cache-Control: no-store, no-cache, must-revalidate');

$host = "localhost";
$user = "root";
$pass = "";
$database = "outagedata";


// $host  = "localhost";
// $user = "vec_oms";
// $pass = "i2NoTgNkB9am";
// $database = "vec_oms";

$total = 0;

$linkID = mysqli_connect($host, $user, $pass, $database) or die("Could not connect to host.");
mysqli_select_db( $linkID, $database) or die("Could not find database.");



//All Outages
$query = "truncate all_outages";
mysqli_query($linkID, $query);

$handle = fopen("import/all_outages.csv", "r");

while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $import="INSERT into all_outages(tk,town,`off`,`on`,`numout`,`cause`,`desc`)values('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."')";
    mysqli_query($linkID, $import) or die(mysqli_error());

}

fclose($handle);

//Number Out
$query = "truncate nbr_out";
mysqli_query($linkID, $query);

$handle = fopen("import/nbr_out.csv", "r");


while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $import="INSERT into nbr_out(`NM`,Total_Out)values('".$data[0]."','".$data[1]."')";
	mysqli_query($linkID, $import) or die(mysqli_error());
}

fclose($handle);


//OMS by town
$query = "truncate oms_by_town_live";
mysqli_query($linkID, $query);

$handle = fopen("import/oms_by_town.csv", "r");

while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $import="INSERT into oms_by_town_live(`out`,town,`off`,`tk`,`etr`)values('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."')";
    mysqli_query($linkID, $import) or die(mysqli_error());

}

fclose($handle);

//OMS lookup
$query = "truncate oms_lookup";
mysqli_query($linkID, $query);

$handle = fopen("import/oms_lookup.csv", "r");

while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $import="INSERT into oms_lookup(`outage`,search,`line`,`etr`)values('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."')";
    mysqli_query($linkID, $import) or die(mysqli_error());

}

fclose($handle);


$query = "truncate oms_lookup_log";
mysqli_query($linkID, $query);



echo("Imports done<br>");
include("./oms.php");
?>