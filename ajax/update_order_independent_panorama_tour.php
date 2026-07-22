<?php
include("../functions.php");

$prod=new Production;

$o_id=$prod->xss_fix($_POST['o_id']);
$independent_panorama_tour=$prod->xss_fix($_POST['independent_panorama_tour']);

$prod->update_order_independent_panorama_tour($o_id,$independent_panorama_tour);

?>