<?php
session_start();
include("../functions.php");

$prod=new Production;

$o_id=$prod->xss_fix($_POST['o_id']);

if(!empty($o_id))
{
$prod->create_targets_for_o_id($o_id);
}
?>