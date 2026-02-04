<?php
include('../functions.php');
$prod=new Production;

$orf_id=$prod->xss_fix($_POST['orf_id']);
$file_name_first_part=$prod->xss_fix($_POST['file_name_first_part']);
$file_name_middle_part=$prod->xss_fix($_POST['orf_name']);
$file_name_last_part=$prod->xss_fix($_POST['file_name_last_part']);

$orf_name=$file_name_first_part.$file_name_middle_part.$file_name_last_part;

$prod->update_orf_name($orf_id,$orf_name);

?>