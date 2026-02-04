<?php

include('../functions.php');
$prod=new Production;

$plan_id=$prod->xss_fix($_POST['plan_id']);
$file_name=$prod->xss_fix($_POST['file_name']);


$prod->plan_object_file_rename($plan_id,$file_name);


?>