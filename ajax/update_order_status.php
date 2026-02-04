<?php
include("../functions.php");

$prod=new Production;

$o_id=$prod->xss_fix($_POST['o_id']);
$o_status=$prod->xss_fix($_POST['o_status']);

$prod->update_order_status($o_id,$o_status);

?>