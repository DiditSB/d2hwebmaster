<?php

$output = shell_exec('gcc main.c -o tes.exe 2>&1');
$outputtext = '';
if(is_null($output))
{
    $outputtext='<p>Compiled Successfully.';
    $outputtext .= '<br/><br/>Output:<br/><hr><br/>';
    $final_out = exec('tes.exe');
    $outputtext.= $final_out;
//    $final_out=shell_exec($prog.'.out '.$cargs.' < inputs.tmp');
//    $outputtext.= $final_out;
} else {
    $outputtext .= $output;
}
echo $outputtext;
?>
