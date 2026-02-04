<?php
include("../functions.php");
$prod=new Production;

$option=$prod->xss_fix($_GET['option']);

if($option=="change_interior_position")
{	
	$subo_id=$prod->xss_fix($_GET['subo_id']);
	$interior_position=$prod->xss_fix($_GET['interior_position']);
	
	$prod->change_orders_subnames_interior_position($subo_id,$interior_position);
}

if($option=="rename_interior_osn_file")
{

	$subo_id=$prod->xss_fix($_GET['subo_id']);
	$interior_subname=$prod->xss_fix($_GET['interior_subname']);
	
	$prod->rename_orders_subnames_file($subo_id,$interior_subname);
}

if($option=="rename_exterior_osn_file")
{

	$subo_id=$prod->xss_fix($_GET['subo_id']);
	$exterior_subname=$prod->xss_fix($_GET['exterior_subname']);
	
	$prod->rename_orders_subnames_file($subo_id,$exterior_subname);
}

if($option=="rename_general_osn_file")
{

	$subo_id=$prod->xss_fix($_GET['subo_id']);
	$general_subname=$prod->xss_fix($_GET['general_subname']);
	
	$prod->rename_orders_subnames_file($subo_id,$general_subname);
}

if($option=="change_object_type")
{

	$subo_id=$prod->xss_fix($_GET['subo_id']);
	$object_type=$prod->xss_fix($_GET['object_type']);
	
	$prod->change_object_type($subo_id,$object_type);
}

if($option=="change_entities_n")
{

	$subo_id=$prod->xss_fix($_GET['subo_id']);
	$e_n_id=$prod->xss_fix($_GET['entities_n']);
	
	$prod->change_e_n_id($subo_id,$e_n_id);
}

if($option=="change_connection_id")
{

	$subo_id=$prod->xss_fix($_GET['subo_id']);
	$connection_id=$prod->xss_fix($_GET['connection_id']);
	
	$prod->change_connection_id($subo_id,$connection_id);
}
?>