<?php
include('../functions.php');

$prod=new Production;

$data['o_id']=$prod->xss_fix($_GET['o_id']);
$data['subo_id']=$prod->xss_fix($_GET['subo_id']);
if(isset($_GET['cf_id']))
{
    $data['cf_id']=$prod->xss_fix($_GET['cf_id']);
}
else
{
    $data['cf_id']="";
}
$data['o_sub_id']=$prod->xss_fix($_GET['o_sub_id']);

$existing_osn_text=$prod->check_existing_subid(json_encode($data));

$prod->change_orders_subnames_of_id($data['subo_id'],$data['cf_id']);
?>