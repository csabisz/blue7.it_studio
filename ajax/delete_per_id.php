<?php
session_start();
include('../functions.php');
$prod=new Production;

$per_id=$prod->xss_fix($_POST['per_id']);
			
$prod->delete_per_ids($per_id);
?>