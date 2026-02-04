<?php
session_start();
include("../functions.php");

$prod=new Production;

$save_perspective_data['o_id']=$prod->xss_fix($_POST['o_id']);
$save_perspective_data['osub_id']=$prod->xss_fix($_POST['osub_id']);
$save_perspective_data['per_kind']=$prod->xss_fix($_POST['new_per_kind_input']);
$save_perspective_data['per_name']=$prod->xss_fix($_POST['new_per_name_input']);
$save_perspective_data['per_description']=$prod->xss_fix($_POST['new_per_description_input']);

if(
(!empty($save_perspective_data['o_id']))&&(!empty($save_perspective_data['osub_id']))&&
(!empty($save_perspective_data['per_kind']))&&(!empty($save_perspective_data['per_name']))
)
{
    $prod->add_perspective_ids(json_encode($save_perspective_data));
}
?>