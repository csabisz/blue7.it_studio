<?php
include('../functions.php');
$prod=new Production;

$orf_id=$prod->xss_fix($_GET['orf_id']);
$orf_status=$prod->xss_fix($_GET['orf_status']);


$prod->update_o_results_status($orf_id,$orf_status);

?>