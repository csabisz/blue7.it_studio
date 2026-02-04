<?php
session_start();
include('../functions.php');
$prod=new Production;

$room_id=$prod->xss_fix($_POST['room_id']);
			
$prod->delete_room_ids($room_id);
?>