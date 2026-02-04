<?php
include("../functions.php");

$prod=new Production;

$data['a_vat']=$prod->xss_fix($_POST['a_vat']);
$data['vat_since']=$prod->xss_fix($_POST['vat_since']);
$data['a_eu']=$prod->xss_fix($_POST['a_eu']);
$data['eu_in']=$prod->xss_fix($_POST['eu_in']);
$data['eu_out']=$prod->xss_fix($_POST['eu_out']);
$data['a_id']=$prod->xss_fix($_POST['a_id']);

$prod->update_area(json_encode($data));
?>