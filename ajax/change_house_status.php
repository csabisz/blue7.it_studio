<?php

include('../functions.php');
$prod=new Production;

$house_id=$prod->xss_fix($_POST['house_id']);
$status=$prod->xss_fix($_POST['status']);

if($status==0)
{
    $status=1;
}
else
{
    $status=0;
}

$prod->change_house_status($house_id,$status);


?>