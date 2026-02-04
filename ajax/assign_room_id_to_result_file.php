<?php
session_start();
include('../functions.php');

$prod=new Production;

$orf_id=$prod->xss_fix($_POST['orf_id']);
$room_id=$prod->xss_fix($_POST['room_id']);


$prod->update_result_file_room_id($orf_id,$room_id);
?>	