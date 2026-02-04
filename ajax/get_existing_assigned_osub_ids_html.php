<?php
include('../functions.php');

$prod=new Production;

$o_id=$prod->xss_fix($_GET['o_id']);
$of_id=$prod->xss_fix($_GET['of_id']);

$all_subids=$prod->get_all_subids_by_o_id($o_id);

for($a=0;$a<count($all_subids);$a++)
{
    // if(strpos($all_subids[$i]['o_sub_id'], 'n') !== false)
    // {

    if (strpos($all_subids[$a]['cf_id'], $of_id) !== false) 
    {
        echo $all_subids[$a]['o_sub_id'].", ";
    }

    //}
}
?>