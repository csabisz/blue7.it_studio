<?php
include('../functions.php');
$prod=new Production;

$orf_id=$prod->xss_fix($_POST['orf_id']);
			
$prod->delete_optimized_image($orf_id);
?>