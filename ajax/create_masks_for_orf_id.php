<?php
session_start();
include("../functions.php");

$prod=new Production;

$orf_id=$prod->xss_fix($_POST['orf_id']);

if(!empty($orf_id))
{
$prod->create_masks_for_orf_id($orf_id);
}
?>