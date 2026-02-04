<?php
include("../functions.php");
$prod=new Production;

$option=$prod->xss_fix($_GET['option']);

if($option=="rename_interior_more_infos")
{

	$subo_id=$prod->xss_fix($_GET['subo_id']);
	$interior_subo_more_infos=$prod->xss_fix($_GET['interior_subo_more_infos']);
	
	$prod->rename_orders_subnames_interior_subo_more_infos($subo_id,$interior_subo_more_infos);
}

if($option=="rename_exterior_more_infos")
{

	$subo_id=$prod->xss_fix($_GET['subo_id']);
	$exterior_subo_more_infos=$prod->xss_fix($_GET['exterior_subo_more_infos']);
	
	$prod->rename_orders_subnames_exterior_subo_more_infos($subo_id,$exterior_subo_more_infos);
}

if($option=="rename_general_more_infos")
{

	$subo_id=$prod->xss_fix($_GET['subo_id']);
	$general_subo_more_infos=$prod->xss_fix($_GET['general_subo_more_infos']);
	
	$prod->rename_orders_subnames_exterior_subo_more_infos($subo_id,$general_subo_more_infos);
}
?>