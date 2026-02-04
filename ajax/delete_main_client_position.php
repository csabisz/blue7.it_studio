<?php
session_start();
include('../functions.php');
$prod=new Production;

$ucb_id=$prod->xss_fix($_POST['ucb_id']);
			
$prod->delete_main_client_position($ucb_id);
?>