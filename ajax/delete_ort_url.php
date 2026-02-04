<?php
session_start();
include("../functions.php");

$prod=new Production;

$ort_id=$prod->xss_fix($_POST['ort_id']);

$prod->delete_target($ort_id);

?>