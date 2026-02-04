<?php

include('../functions.php');
$prod=new Production;

$plan_id=$prod->xss_fix($_POST['plan_id']);
$title=$prod->xss_fix($_POST['title']);


$prod->plan_object_title_rename($plan_id,$title);


?>