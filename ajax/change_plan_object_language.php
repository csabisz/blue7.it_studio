<?php

include('../functions.php');
$prod=new Production;

$plan_id=$prod->xss_fix($_POST['plan_id']);
$lang_id=$prod->xss_fix($_POST['lang_id']);


$prod->plan_object_change_language($plan_id,$lang_id);


?>