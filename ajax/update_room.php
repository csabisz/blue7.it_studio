<?php
include("../functions.php");

$prod=new Production;


$save_room_data['room_id']=$prod->xss_fix($_POST['room_id']);
$save_room_data['room_number']=$prod->xss_fix($_POST['update_room_number_input']);
$save_room_data['rk_id']=$prod->xss_fix($_POST['update_room_kind_input']);
$save_room_data['room_name']=$prod->xss_fix($_POST['update_room_name_input']);
$save_room_data['room_description']=$prod->xss_fix($_POST['update_room_description_input']);

$prod->update_room_ids(json_encode($save_room_data));
?>