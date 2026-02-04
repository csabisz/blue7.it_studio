<?php
include('../functions.php');

$prod=new Production;

$mc_id=$prod->xss_fix($_GET['mc_id']);

$main_client=$prod->get_main_client($mc_id);

echo $main_client['clientname'];
?>