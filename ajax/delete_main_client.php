<?php
include('../functions.php');
$prod = new Production;

$mc_id = $prod->xss_fix($_POST['mc_id']);

$prod->delete_main_client($mc_id);
?>
