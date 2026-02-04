<?php
session_start();
include("../functions.php");

$prod=new Production;

$orme_id=$prod->xss_fix($_POST['orme_id']);

$prod->delete_mask_coordinates($orme_id);

?>