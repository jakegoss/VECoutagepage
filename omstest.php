<?php
require_once 'all_outages.csv';
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


<!-- <div>
    Town<input type="text"><br/>
    Meter#<input type="number"><br/>
    Time Off<input type="datetime-local"><br/>
    Estimated Restoration Time<input type="datetime-local">
</div> -->



<?php



// W3 table solution

echo "<table style='border: solid 1px black;'>";
echo "<tr>
 <th>tk</th>
 <th>town</th>
 <th>off</th>
 <th>on</th>
 <th>cause</th>
 <th>desc</th>
 </tr>";

class TableRows extends RecursiveIteratorIterator
{
    public function __construct($it)
    {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    public function current()
    {
        return "<td style='width: 150px; border: 1px solid black;'>" . parent::current() . "</td>";
    }

    public function beginChildren()
    {
        echo "<tr>";
    }

    public function endChildren()
    {
        echo "</tr>" . "\n";
    }
}




//   -------- Build table function-----------

//     function build_table($array){
//     // start table
//     $html = '<table>';
//     // header row
//     $html .= '<tr>';
//     foreach($array[0] as $key=>$value){
//             $html .= '<th>' . htmlspecialchars($key) . '</th>';
//         }
//     $html .= '</tr>';

//     // data rows
//     foreach( $array as $key=>$value){
//         $html .= '<tr>';
//         foreach($value as $key2=>$value2){
//             $html .= '<td>' . htmlspecialchars($value2) . '</td>';
//         }
//         $html .= '</tr>';
//     }

//     finish table and return it

//     $html .= '</table>';
//     return $html;
// }

// ---------------Placehold table----------------

// $array = array(
//     array('Town'=>'Troy', 'Meter #'=>'12', 'Time Off'=>'01/12 9:20am', 'Estimated Restoration Time'=>'01/13 10:30am'),
//     array('Town'=>'Albany', 'Meter #'=>'44', 'Time Off'=>'01/12 11:33am', 'Estimated Restoration Time'=>'01/13 10:00am'),
//     array('Town'=>'Stowe', 'Meter #'=>'23', 'Time Off'=>'01/12 01:51pm', 'Estimated Restoration Time'=>'01/13 12:10pm')
// );

?>
</body>
</html>




