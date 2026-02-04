<?php
include('../functions.php');
$prod=new Production;

echo $orf_id=$prod->xss_fix($_GET['orf_id']);
echo $bd_status=$prod->xss_fix($_GET['bd_status']);


$prod->update_o_results_bd_status($orf_id,$bd_status);

?>