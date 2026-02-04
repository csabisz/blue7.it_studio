<?php
session_start();
include("../functions.php");

$prod=new Production;

$insert_no_result_file_data['o_id']=$prod->xss_fix($_POST['o_id']);
$insert_no_result_file_data['osub_id']=$prod->xss_fix($_POST['osub_id']);
$insert_no_result_file_data['prod_id']=$prod->xss_fix($_POST['prod_id']);
$insert_no_result_file_data['uca_id']=$prod->xss_fix($_POST['uca_id']);

$prod->insert_no_result_file(json_encode($insert_no_result_file_data));

?>