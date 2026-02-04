<?php
session_start();
include("../functions.php");

$prod=new Production;

$o_id=$prod->xss_fix($_POST['o_id']);
$osub_id=$prod->xss_fix($_POST['osub_id']);
$prod_id=$prod->xss_fix($_POST['prod_id']);
$uca_id=$prod->xss_fix($_POST['uca_id']);

if((!empty($o_id))&&(!empty($osub_id))&&(!empty($prod_id))&&(!empty($uca_id)))
{
    $data['o_id']=$o_id;
    $data['osub_id']=$osub_id;
    $data['prod_id']=$prod_id;
    $data['uca_id']=$uca_id;

    $prod->create_suntour_model(json_encode($data));
}
?>