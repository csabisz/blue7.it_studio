<?php
include("../functions.php");

$prod=new Production;

$client_id=$prod->xss_fix($_GET['purchaser']);

$client=$prod->get_client($client_id);

echo $client['client_price_remarks'];
?>