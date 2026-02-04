<?php
include("../functions.php");

$prod=new Production;

$client_id=$prod->xss_fix($_POST['client_id']);
$client_price_remarks=$prod->xss_fix($_POST['client_price_remarks']);

if(!empty($client_price_remarks))
{
$prod->update_simple_client_price_remarks($client_id,$client_price_remarks);
}
?>