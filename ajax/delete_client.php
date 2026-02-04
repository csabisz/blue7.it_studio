<?php
include('../functions.php');
$prod = new Production;

$client_id = $prod->xss_fix($_POST['client_id']);

$prod->delete_client($client_id);
?>
