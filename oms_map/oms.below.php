<!-- Oms Last 24 hours for lower section -->


<?php


#$useragent=$_SERVER['HTTP_USER_AGENT'];
#if((preg_match('/android|avantgo|blackberry|blazer|elaine|hiptop|ip(hone|od)|kindle|midp|mmp|mobile|o2|opera mini|palm( os)?|pda|plucker|pocket|psp|smartphone|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce; (iemobile|ppc)|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) && ($_SERVER['REQUEST_URI'] != '/custom/oms/oms.php'))
#header('Location: /custom/oms/oms.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb" dir="ltr">
<head>
<link href="/templates/vec/css/template.css" rel="stylesheet" type="text/css" />
</head>

<body class="site com_content view-article no-layout no-task itemid-209 fluid">

<?php

$host = "localhost";
$user = "vec_oms";
$pass = "i2NoTgNkB9am";
$database = "vec_oms";

$total = 0;

$linkID = mysqli_connect($host, $user, $pass, $database) or die("Could not connect to host.");
mysqli_select_db( $linkID, $database) or die("Could not find database.");

?>

<h4 style="text-align: center;">Recent Outages (last 24 hours)</h4>
<table class="outage">   <thead > 
<tr>
<th bgcolor='#0082c8'><font color="white">Town</font></th>
<th bgcolor='#0082c8'><font color="white">#M</font></th>
<th bgcolor='#0082c8'><font color="white">Time Off</font></th>
<th bgcolor='#0082c8'><font color="white">Time on</font></th>
<th bgcolor='#0082c8'><font color="white">Cause</font></th>
<th bgcolor='#0082c8'><font color="white">Outage ID</font></th></tr>
</thead>

<?php

// $query = 'SELECT *,max(timestamp) FROM all_outages where `on` != "" and numout > 0 group by tk,town,off order by `on` desc';  These queries are not working in this syntax
$query = 'SELECT * FROM all_outages where numout > 0 order by `on` desc';
$resultID = mysqli_query($linkID, $query);
for($x = 0 ; $x < mysqli_num_rows($resultID) ; $x++){
   $row = mysqli_fetch_assoc($resultID);
 	 $tk = $row['tk'];
	 $town = $row['town'];
	 $off = $row['off'];
	 $off = str_replace(array('am','pm'),array(' a.m.',' p.m.'),date("n/j g:ia", strtotime($off)));
	 $on = $row['on'];
	 $on = str_replace(array('am','pm'),array(' a.m.',' p.m.'),date("n/j g:ia", strtotime($on)));
   	$numout = $row['numout'];
	 $cause = $row['cause'];
	 $desc = $row['desc'];

	 echo "<tr>
	 <td align=center>$town</td>
	 <td align=center bgcolor='#f5f5f5'>$numout</td>
	 <td align=center>$off</td>
	 <td align=center bgcolor='#f5f5f5'>$on</td>
	 <td align=center>$cause</td>
	 <td align=center bgcolor='#f5f5f5'>$tk</td></tr>\n";
	 }
echo "</table>&nbsp;\n";
if (mysqli_num_rows($resultID) == 0) {
   echo "<b>There are no outages to display.</b><br>\n";
}
echo "</center>";

?>

</body>
</html>
