<?php
include('../functions.php');

$prod=new Production;

$uca_id=$prod->xss_fix($_GET['uca_id']);

$creator=$prod->get_client($uca_id);

echo $creator['clientname']." - ";
if(!empty($creator['c_last_name']))
{
    echo $creator['c_first_name']." ".$creator['c_last_name'];
}
else
{
    echo $creator['l_first_name']." ".$creator['l_last_name'];
}
?>