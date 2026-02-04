<?php
include('../functions.php');

$prod=new Production;

$osn_id=$prod->xss_fix($_POST['osn_id']);

if((!empty($osn_id))&&($osn_id>0))
{
    $prod->delete_orders_subnames_osn_id($osn_id);
}
?>