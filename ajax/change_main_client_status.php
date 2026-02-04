<?php
include("../functions.php");

$prod=new Production;

$mc_id=$prod->xss_fix($_POST['mc_id']);
$option=$prod->xss_fix($_POST['option']);

if($option=="change_main_client_status")
{
	$main_client=$prod->get_main_client($mc_id);
	
	if($main_client['inactive']==0)
	{
        $prod->update_main_client_status($mc_id,1);
        
		echo "Inactive";
	}
	else
	{
		$prod->update_main_client_status($mc_id,0);
		echo "Active";
	}	
}
?>