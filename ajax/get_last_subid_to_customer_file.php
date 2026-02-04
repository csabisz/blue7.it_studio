<?php
include('../functions.php');

$prod=new Production;

$of_id=$prod->xss_fix($_GET['of_id']);

echo $orders_subnames=$prod->get_last_subid_to_customer_file($of_id)['osn_id'];

?>