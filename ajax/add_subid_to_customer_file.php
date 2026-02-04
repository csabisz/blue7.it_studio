<?php
include('../functions.php');

$prod=new Production;

$data['of_name']=$prod->xss_fix($_POST['of_name']);
$data['of_id']=$prod->xss_fix($_POST['of_id']);
$data['o_id']=$prod->xss_fix($_POST['o_id']);
$data['osub_id']=$prod->xss_fix($_POST['osub_id']);

$prod->add_sub_id_to_customer_file(json_encode($data));
?>