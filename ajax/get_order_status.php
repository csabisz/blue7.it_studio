<?php
include('../functions.php');

$prod=new Production;

$o_id=$prod->xss_fix($_GET['o_id']);

$order=$prod->get_order($o_id);

echo $order['o_status'];
?>