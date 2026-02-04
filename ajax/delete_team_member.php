<?php
include('../functions.php');
$prod=new Production;

$ut_id=$prod->xss_fix($_POST['ut_id']);
			
$prod->delete_team_member($ut_id);
?>