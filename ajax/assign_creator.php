<?php
session_start();
include('../functions.php');
include('../notifications.php');

$prod=new Production;

$o_id=$prod->xss_fix($_GET['o_id']);
$osub_id=$prod->xss_fix($_GET['osub_id']);
$prod_id=$prod->xss_fix($_GET['prod_id']);
$creatorid=$prod->xss_fix($_GET['creatorid']);

$order=$prod->get_order($o_id);
$licenceid=$order['lic_ID'];

if($prod_id=="p1501")
{
	$prod->assign_to_creator($o_id,$osub_id,$prod_id,$creatorid,1,1,4);
}
else
{
	$check_p_status=$prod->check_assigned_status($o_id,$osub_id,$prod_id);

	if($check_p_status['p_status']==3)
	{
		$prod->assign_to_creator($o_id,$osub_id,$prod_id,$creatorid,1,1,4);
	}
	else
	{
		$prod->assign_to_creator($o_id,$osub_id,$prod_id,$creatorid,1,1,2);
	}
}

$logged_in_user_id=$prod->get_client($creatorid);
if(!empty($logged_in_user_id['c_last_name']))
{
    $creator_name=$logged_in_user_id['c_first_name']." ".$logged_in_user_id['c_last_name'];
}
else
{
    $creator_name=$logged_in_user_id['l_first_name']." ".$logged_in_user_id['l_last_name'];
}
$prod->create_activity($_COOKIE['client_id'],"assigned to ".$creator_name,$o_id,$osub_id,$prod_id);

$prod->update_order_status($o_id,$o_status=2);
?>	