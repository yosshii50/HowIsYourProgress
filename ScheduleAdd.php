<?php

$date      = filter_input( INPUT_POST , 'date'      );
$data      = filter_input( INPUT_POST , 'data'      );
$backcolor = filter_input( INPUT_POST , 'backcolor' );

$file = 'Schedule.txt';

$current = file_get_contents( $file );

$current .= $date      . "\t";
$current .= $data      . "\t";
$current .= $backcolor . "\t";
$current .= "\n";
//          ↑           ↑  特殊文字なので[']ではNG

file_put_contents( $file , $current );

?>

