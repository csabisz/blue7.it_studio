<?php
session_start();
include("../functions.php");

$prod=new Production;

$data['ort_id']=$prod->xss_fix($_POST['ort_id']);
$data['ort_text']=$prod->xss_fix($_POST['ort_text']);

$prod->update_ort_text(json_encode($data));

?>