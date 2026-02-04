<?php

include("../functions.php");

$prod = new Production;

$data['osn_id'] = $prod->xss_fix($_POST['osn_id']);
$data['o_id'] = $prod->xss_fix($_POST['o_id']);
$data['osub_id'] = $prod->xss_fix($_POST['osub_id']);
$data['of_name'] = $prod->xss_fix($_POST['osn_text']);

if($data['osn_id']==0)
{
    $check=$prod->check_existing_subid(json_encode($data));

    if(empty($check))
    {
        $prod->add_sub_id_to_customer_file(json_encode($data));
    }
    else
    {
        $prod->rename_orders_subnames_file($check['osn_id'],$data['of_name']);
    }
}
else
{
    $prod->rename_orders_subnames_file($data['osn_id'],$data['of_name']);
} 
?>