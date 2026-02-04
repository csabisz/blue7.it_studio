<?php

include('../functions.php');
$prod=new Production;

$plan_id=$prod->xss_fix($_POST['plan_id']);
$plan_kind=$prod->xss_fix($_POST['plan_kind']);


$prod->plan_object_change_kind($plan_id,$plan_kind);


?>