<?php
session_start();
include('../functions.php');
$prod=new Production;

$e_n_id=$prod->xss_fix($_POST['e_n_id']);
			
$prod->delete_interior_entity($e_n_id);
?>