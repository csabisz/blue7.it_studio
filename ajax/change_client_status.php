<?php
include("../functions.php");

$prod=new Production;

$client_id=$prod->xss_fix($_POST['client_id']);
$option=$prod->xss_fix($_POST['option']);

if($option=="change_client_status")
{
	$client=$prod->get_client($client_id);
	
	if($client['c_status']=="active")
	{
        $prod->update_client_status($client_id,"inactive");
        $client_rights=$prod->get_client_rights($client_id);

        if(count($client_rights)>0)
        {
            $data['client_id']=$client_id;
            $data['u_status']="inactive";

            $prod->update_client_rights_status(json_encode($data));
        }
        
		echo "Inactive";
	}
	else
	{
		$prod->update_client_status($client_id,"active");
		echo "Active";
	}	
}
?>