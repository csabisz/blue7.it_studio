<?php
session_start();
include("../functions.php");

$prod=new Production;


$save_perspective_data['per_id']=$prod->xss_fix($_POST['per_id']);
$save_perspective_data['per_kind']=$prod->xss_fix($_POST['update_per_kind_input']);
$save_perspective_data['per_name']=$prod->xss_fix($_POST['update_per_name_input']);
$save_perspective_data['per_description']=$prod->xss_fix($_POST['update_per_description_input']);

$prod->update_per_ids(json_encode($save_perspective_data));
?>