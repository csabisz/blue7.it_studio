<?php
session_start();
include("../functions.php");

$prod=new Production;

$data['ort_id']=$prod->xss_fix($_POST['ort_id']);
$data['second_ort_url']=$prod->xss_fix($_POST['second_ort_url']);

$prod->update_second_ort_url(json_encode($data));

?>