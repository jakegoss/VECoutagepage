<?php
#$useragent=$_SERVER['HTTP_USER_AGENT'];
#if((preg_match('/android|avantgo|blackberry|blazer|elaine|hiptop|ip(hone|od)|kindle|midp|mmp|mobile|o2|opera mini|palm( os)?|pda|plucker|pocket|psp|smartphone|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce; (iemobile|ppc)|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) && ($_SERVER['REQUEST_URI'] != '/custom/oms/oms.php'))
#header('Location: /custom/oms/oms.php');
?>

<head>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb" dir="ltr">
<link href="/templates/vec/css/template.css" rel="stylesheet" type="text/css" />
</head>

<body class="site com_content view-article no-layout no-task itemid-207 fluid">


<?php

$host = "localhost";
$user = "vec_oms";
$pass = "i2NoTgNkB9am";
$database = "vec_oms";

$total = 0;

$linkID = mysqli_connect($host, $user, $pass, $database) or die("Could not connect to host.");
mysqli_select_db($linkID, $database) or die("Could not find database.");

// query for search and dashboard view

$query = "select *,max(timestamp) from oms_by_town_live group by tk";
$resultID = mysqli_query($linkID, $query);
$outage_count = mysqli_num_rows($resultID);
echo "<center>";

// query for total towns affected

$query = "select * from oms_by_town_live";
$resultID2 = mysqli_query($linkID, $query);
$town_total = mysqli_num_rows($resultID2);

// $query = "select *,max(timestamp) from oms_by_town_live group by tk,town order by town,off";
// $resultID = mysqli_query($linkID,$query);

// query total out for dashboard

$query_total = "select Total_Out from nbr_out";
$resultID_t = mysqli_query($linkID, $query_total);
$row_t = mysqli_fetch_assoc($resultID_t);
$total = $row_t['Total_Out'];

$query = "show table status where Name = 'oms_by_town_live'";
$resultID = mysqli_query($linkID, $query);
$row = mysqli_fetch_assoc($resultID);
$updated = $row['Update_time'];
$updated = date("m/d h:ia", strtotime($updated));

for ($x = 0; $x < mysqli_num_rows($resultID); $x++) {
    $row = mysqli_fetch_assoc($resultID);
    $out = $row['out'];
    $town = $row['town'];
    $tk = $row['tk'];
    $off = $row['off'];
    $off = date("m/d h:ia", strtotime($off));
    $etr = $row['etr'];
    if ($etr != null) {
        $etr = date("m/d h:ia", strtotime($etr));
    } else {
        $etr = "TBD";
    }
    $current = $current . "<tr>
					  <td align=center><font size=3>$updated</font></td>
					  <td align=center><font size=3>$town</font></td>
					  <td align=center><font size=3>$out</font></td>
					  <td align=center><font size=3>$off</font></td>
					  </tr>\n";
}

$updatedata = "<tr>
	 <td align=center><font size=3>$updated</font></td>
	 <td align=center><font size=3>$total</font></td>
	 <td align=center><font size=3>$outage_count</font></td>
	 <td align=center><font size=3>$town_total</font></td>
	 </tr>\n";

echo "<table width=80% cellpadding=4>\n";
echo "<tr>
			  <th bgcolor='#e47322' align=center><font color='white' size=3>Last Updated</font></th>
			  <th bgcolor='#e47322' align=center><font color='white' size=3>Members Affected</font></th>
			<th bgcolor='#e47322' align=center><font color='white' size=3>Outage Incident(s)</font></th>
			<th bgcolor='#e47322' align=center><font color='white' size=3>Town(s) Affected</font></th>\n";
echo $updatedata;
echo "</table>";

if ($outage_count > 0) {

    echo "<div padding-top: 10px; margin-bottom: 10px;'>";
    echo "<form action='" . $_SERVER["PHP_SELF"] . "' style='background-color: #ffffff; height: 25px;' method='post'>Account Number: <input size=20 name=search> <input type=submit value='Search'> </form>\n";
    echo "<span><font size=3>Enter your account # to get the estimated restoration time for your outage. If you do not know your account number, please call 1-800-832-2667. Note: if you enter your account # and the reply is \"account not found\" your outage is not recorded in our system. Please inform us by calling or through your <a href='https://vermontelectric.smarthub.coop/Login.html'>SmartHub account</a>.</font></span><br>\n";
    echo "</div>";

    $search = filter_var($_REQUEST['search'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_AMP);

// query for search

#if ($search > 1) {
    #     $ip = $_SERVER['REMOTE_ADDR'];
    #     $query = "insert into oms_lookup_log (search,ip) VALUES ('$search','$ip')";
    #     mysqli_query($linkID, $query);

#     $query = "SELECT ip, search FROM `oms_lookup_log` where timestamp > DATE_SUB(NOW(), INTERVAL 5 MINUTE) and ip = '$ip'";
    #     $resultID2 = mysqli_query($linkID, $query);
    #     $row2 = mysqli_fetch_assoc($resultID2);
    #     $trys = mysqli_num_rows($resultID2);

#     if ($trys > 10) {
    #             echo "<b>Due to security the system can only be queried every 5 minutes</b><br><br>\n";
    #            $search = "";
    #     }
    #}

    if ($search > 1) {

        $query = "select * from oms_lookup where search='$search' and etr is NULL";
        $resultID1 = mysqli_query($linkID, $query);
        $outage_search = mysqli_num_rows($resultID1);
        if (mysqli_num_rows($resultID1) == 0) {
            $query = "select * from oms_lookup where search=md5('$search') order by etr desc";
            $resultID1 = mysqli_query($linkID, $query);
            $outage_search = mysqli_num_rows($resultID1);
        }

        if (mysqli_num_rows($resultID1) == 0) {
            echo "<b>Account Not Found</b><br>\n";
        } else {
            $row1 = mysqli_fetch_assoc($resultID1);
            $account = "Found";
            $etr = $row1['etr'];
            $line = $row1['line'];

            if (($etr != null) and ($etr != "0000-00-00 00:00:00")) {
                $etr = date("m/d h:ia", strtotime($etr));
            } else {
                $etr = "TBD";
            }

            echo "<table width=100% cellpadding=4>\n";
            echo "<tr><th bgcolor='#cccccc' align=left ><font size=2>Account</font></th><th bgcolor='#cccccc' align=left><font size=2>Estimated<br>Restoration Time</font></th><th bgcolor='#cccccc' align=center><font   size=2>Ticket#</font></th></tr>\n";
            echo "<tr><td><font size=2>$account</font></td><td><font size=2>$etr</font></td><td><font size=2>$line</font></td>\n";
            echo "</table>";

        }
        echo "<br><br>\n";
    }
}

?>

</body>
</html>