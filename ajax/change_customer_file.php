<?php
include("../functions.php");
$prod=new Production;

$option=$prod->xss_fix($_GET['option']);

if($option=="change_position")
{
	//$change_position=explode(";",$prod->xss_fix($_GET['change_position']));
	
	$of_id=$prod->xss_fix($_GET['of_id']);
	$of_position=$prod->xss_fix($_GET['change_position']);
	
	$prod->change_of_position($of_id,$of_position);
}

if($option=="change_exterior_position")
{
	//$change_position=explode(";",$prod->xss_fix($_GET['change_exterior_position']));
	
	$of_id=$prod->xss_fix($_GET['of_id']);
	$of_position=$prod->xss_fix($_GET['change_exterior_position']);
	
	$prod->change_of_exterior_position($of_id,$of_position);
}

if($option=="change_note")
{
	$change_note=explode(";",$prod->xss_fix($_GET['change_note']));
	/*$of_id=$prod->xss_fix($_GET['of_id']);
	$of_kind=$prod->xss_fix($_GET['of_kind']);*/
	$of_id=$change_note[0];
	$of_kind=$change_note[1];
	
	$prod->change_of_kind($of_id,$of_kind);
}

if($option=="change_level")
{
	$change_level=explode(";",$prod->xss_fix($_GET['change_level']));
	
	$of_id=$change_level[0];
	$of_level=$change_level[1];
	
	$prod->change_of_level($of_id,$of_level);
}

if($option=="rename_in_customer_file")
{
    $of_id=$prod->xss_fix($_GET['of_id']);
	$of_name=$prod->xss_fix($_GET['of_name']);

	$prod->rename_in_client_file($of_id,$of_name);
}

if($option=="rename_ex_customer_file")
{
    $of_id=$prod->xss_fix($_GET['of_id']);
    $of_name_ex=$prod->xss_fix($_GET['of_name_ex']);

	$prod->rename_ex_client_file($of_id,$of_name_ex);
}
?>