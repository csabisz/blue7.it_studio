<?php
include("../functions.php");

$prod=new Production;

$client_id=$prod->xss_fix($_GET['purchaser']);

$client=$prod->get_client($client_id);

$main_client=$prod->get_main_client($client['mc_id']);

echo $main_client['price_remarks'];
?>