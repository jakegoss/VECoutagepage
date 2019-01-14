<?php
    function build_table($array){
    // start table
    $html = '<table>';
    // header row
    $html .= '<tr>';
    foreach($array[0] as $key=>$value){
            $html .= '<th>' . htmlspecialchars($key) . '</th>';
        }
    $html .= '</tr>';

    // data rows
    foreach( $array as $key=>$value){
        $html .= '<tr>';
        foreach($value as $key2=>$value2){
            $html .= '<td>' . htmlspecialchars($value2) . '</td>';
        }
        $html .= '</tr>';
    }

    // finish table and return it

    $html .= '</table>';
    return $html;
}

$array = array(
    array('Town'=>'Troy', 'Meter #'=>'12', 'Time Off'=>'01/12 11:20am', 'Estimated Restoration Time'=>'example ltd'),
    array('Town'=>'Albany', 'Meter #'=>'44', 'Time Off'=>'01/12 11:20am', 'Estimated Restoration Time'=>'example ltd'),
    array('Town'=>'Stowe', 'Meter #'=>'23', 'Time Off'=>'01/12 11:20am', 'Estimated Restoration Time'=>'example ltd')
);

echo build_table($array);
?>