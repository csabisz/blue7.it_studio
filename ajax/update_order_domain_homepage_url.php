<?php
include("../functions.php");

$prod=new Production;

$o_id=$prod->xss_fix($_POST['o_id']);
$domain_homepage_url=$prod->xss_fix($_POST['domain_homepage_url']);

$prod->update_order_domain_homepage_url($o_id,$domain_homepage_url);

?>