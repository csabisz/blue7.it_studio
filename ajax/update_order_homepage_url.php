<?php
include("../functions.php");

$prod=new Production;

$o_id=$prod->xss_fix($_POST['o_id']);
$homepage_url=$prod->xss_fix($_POST['homepage_url']);

$prod->update_order_homepage_url($o_id,$homepage_url);

?>