<?php
session_start();
include('../functions.php');

$prod=new Production;

$o_id=$prod->xss_fix($_POST['o_id']);
$client_id=$prod->xss_fix($_POST['client_id']);

$prod->update_order_status($o_id,$o_status=12);
$prod->create_activity($client_id,"deleted order",$o_id,"","");
?>