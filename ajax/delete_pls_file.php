<?php

include('../functions.php');
$prod=new Production;

$plan_id=$prod->xss_fix($_POST['plan_id']);

$pls_file=$prod->get_pls_file_by_plan_id($plan_id);

$file_path="../plans_architectural/".$pls_file['file_path'];

if(file_exists($file_path)) 
{
    unlink($file_path);
}

$prod->delete_plan_by_id($plan_id);


?>