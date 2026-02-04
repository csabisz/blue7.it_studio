<?php
session_start();
include("../functions.php");

$prod=new Production;

$data['orme_id']=$prod->xss_fix($_POST['orme_id']);
$data['mask_coordinates']=$prod->xss_fix($_POST['mask_coordinates']);

$prod->update_mask_coordinates(json_encode($data));

?>