<?php
include('../functions.php');
$prod=new Production;

echo $orf_id=$prod->xss_fix($_GET['orf_id']);
echo $hover_status=$prod->xss_fix($_GET['hover_status']);


$prod->update_o_results_hover_status($orf_id,$hover_status);

?>