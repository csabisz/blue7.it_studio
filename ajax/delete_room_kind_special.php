<?php
include('../functions.php');
$prod=new Production;

$rks_id=$prod->xss_fix($_POST['rks_id']);
			
$prod->delete_room_kind_special($rks_id);
?>