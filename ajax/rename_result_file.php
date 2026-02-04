<?php
include('../functions.php');
$prod=new Production;

$orf_id=$prod->xss_fix($_POST['orf_id']);


$file_name_first_part=$prod->xss_fix($_POST['file_name_first_part']);
$file_name_middle_part=$prod->xss_fix($_POST['file_name']);
$file_name_last_part=$prod->xss_fix($_POST['file_name_last_part']);

$file_name=$file_name_first_part.$file_name_middle_part.$file_name_last_part;

$prod->result_file_rename($orf_id,$file_name);

?>