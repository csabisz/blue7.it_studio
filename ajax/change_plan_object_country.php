<?php

include('../functions.php');
$prod=new Production;

$plan_id=$prod->xss_fix($_POST['plan_id']);
$a_id=$prod->xss_fix($_POST['a_id']);


$prod->plan_object_change_country($plan_id,$a_id);


?>