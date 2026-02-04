<?php
include("../functions.php");

$prod=new Production;

$mc_id=$prod->xss_fix($_POST['mc_id']);
$price_remarks=$prod->xss_fix($_POST['price_remarks']);

if(!empty($price_remarks))
{
$prod->update_main_client_price_remarks($mc_id,$price_remarks);
}
?>