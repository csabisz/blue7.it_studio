<?php
include('../functions.php');

$prod=new Production;

$o_id=$prod->xss_fix($_GET['o_id']);
$osub_id=$prod->xss_fix($_GET['osub_id']);
$prod_id=$prod->xss_fix($_GET['prod_id']);
$uca_id=$prod->xss_fix($_GET['uca_id']);

$creator=$prod->get_client($uca_id);

if(!empty($creator['c_last_name']))
{
    echo $creator['c_first_name']." ".$creator['c_last_name'];
}
else
{
    echo $creator['l_first_name']." ".$creator['l_last_name'];
}

$activity=$prod->get_product_last_change($o_id,$osub_id,$prod_id);

if(!empty($activity))
{
   $activity_creator=$prod->get_client($activity['uca_id']);

   if(!empty($activity_creator['c_last_name']))
   {
       echo " - ".$activity_creator['c_first_name']." ".$activity_creator['c_last_name'];
   }
   else
   {
       echo $activity_creator['l_first_name']." ".$activity_creator['l_last_name'];
   }
   echo " ".$activity['description']." on ".$activity['date'];
}
?>