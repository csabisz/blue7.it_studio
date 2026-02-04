<?php
session_start();
include("../functions.php");

$prod=new Production;

$data['ort_id']=$prod->xss_fix($_POST['ort_id']);
$data['ort_url']=$prod->xss_fix($_POST['ort_url']);

$prod->update_ort_url(json_encode($data));

?>