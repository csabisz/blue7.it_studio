<?php
session_start();
include('../functions.php');

$prod=new Production;

$orf_id=$prod->xss_fix($_POST['orf_id']);
$per_id=$prod->xss_fix($_POST['per_id']);


$prod->update_result_file_per_id($orf_id,$per_id);
?>	