<?php
session_start();
include("../functions.php");

$prod=new Production;

$save_room_data['o_id']=$prod->xss_fix($_POST['o_id']);
$save_room_data['osub_id']=$prod->xss_fix($_POST['osub_id']);
$save_room_data['room_number']=$prod->xss_fix($_POST['new_room_number_input']);
$save_room_data['rk_id']=$prod->xss_fix($_POST['new_room_kind_input']);
$save_room_data['room_name']=$prod->xss_fix($_POST['new_room_name_input']);
$save_room_data['room_description']=$prod->xss_fix($_POST['new_room_description_input']);

if(
(!empty($save_room_data['o_id']))&&(!empty($save_room_data['osub_id']))&&
(!empty($save_room_data['room_number']))&&(!empty($save_room_data['rk_id']))
)
{
    $prod->add_room_ids(json_encode($save_room_data));
}
?>