<?php
session_start();
include('../functions.php');

$prod=new Production;

$o_id=$prod->xss_fix($_POST['o_id']);
$lic_id=$prod->xss_fix($_POST['lic_id']);

$prod->update_order_lic_id($o_id,$lic_id);
?>