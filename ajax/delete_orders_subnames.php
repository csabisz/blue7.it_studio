<?php
include('../functions.php');

$prod=new Production;

$subo_id=$prod->xss_fix($_POST['subo_id']);

if((!empty($subo_id))&&($subo_id>0))
{
    $prod->delete_orders_subnames_subo_id($subo_id);
}
?>