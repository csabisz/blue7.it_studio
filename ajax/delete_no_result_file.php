<?php
session_start();
include("../functions.php");

$prod=new Production;

$delete_no_result_file_data['o_id']=$prod->xss_fix($_POST['o_id']);
$delete_no_result_file_data['osub_id']=$prod->xss_fix($_POST['osub_id']);
$delete_no_result_file_data['prod_id']=$prod->xss_fix($_POST['prod_id']);

$prod->delete_no_result_file(json_encode($delete_no_result_file_data));

?>