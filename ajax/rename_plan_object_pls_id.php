<?php

include('../functions.php');
$prod=new Production;

$plan_id=$prod->xss_fix($_POST['plan_id']);
$pls_id=$prod->xss_fix($_POST['pls_id']);


$prod->plan_object_pls_id_rename($plan_id,$pls_id);


?>