<?php
include('../functions.php');
$prod=new Production;

$orf_id=$prod->xss_fix($_POST['orf_id']);
$result_file_verified=$prod->xss_fix($_POST['result_file_verified']);


$prod->update_o_results_verified($orf_id,$result_file_verified);

?>